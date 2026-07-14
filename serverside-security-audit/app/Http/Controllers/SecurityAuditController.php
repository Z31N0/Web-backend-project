<?php

namespace App\Http\Controllers;

use App\Mail\AuditReport;
use App\Models\Account;
use App\Models\Audit;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as Response;

class SecurityAuditController extends Controller
{
    function getAllAccounts(): array
    {
        return ["data" => Account::all()];
    }

    function getAllOrganizations(): array
    {
        return ["data" => Organization::all()];
    }


    # TODO Logic of my execute Audit should be reviewed but no time left
    function executeAudit(Request $request): Audit|JsonResponse
    {
        $validator = Validator::make($request -> all(), $this -> buildRules());
        if ($validator -> fails()) {
            return response() -> json(["errors" => $validator -> errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $audit = new Audit($validator->validated());
            $account = $validator->validated()["accounts"];
            $passwordStrength = $this->calculatepasswordStrength($account);
            $maxWeakPasswords = Organization::find($validator->validated()["organization_id"])->max_weak_passwords ?? 0;

            $weakPasswords = count(array_filter($account, function ($account_id) {
                $account = Account::find($account_id);
                return $account && strlen($account->password) < 8;
            }));
            $audit->success = $passwordStrength >= 12 && $weakPasswords <= $maxWeakPasswords;

            $audit->report = $this->buildReport($audit, $account);

            $audit->save();
            $this->sendConfirmationMail($audit);

            return $audit;

        }
    }


    function calculatePasswordStrength($accounts): int
    {
        $strength = 0;

        foreach ($accounts as $account_id) {
            $account = Account::find($account_id);

            if ($account) {
                $strength += strlen($account->password) + $this->countUppercase($account->password) * 2 + $this->countNumbers($account->password) * 2 + $this->countPunctuation($account->password) * 3;
            }
        }

        return $strength;
    }

    function buildReport($audit, $account)
    {
        if ($audit->success) {
            return "Audit succeed. weak passwords found for: " . $this->getAccountsNames($account);
        } else {
            return "Audit failed. weak passwords found for: " . $this->getAccountsNames($account);
        }
    }

    function getAccountsNames($accounts)
    {
        $names = [];

        foreach ($accounts as $account_id) {
            $account = Account::find($account_id);

            if ($account) {
                $names[] = $account->name;
            }
        }

        return join(",", $names);
    }




    function buildRules(): array
    {
        return [
            "auditor" => "required|email|max:255",
            "organization_id" => "required|exists:organizations,id",
            "accounts" => "required|array|min:1"
        ];
    }

    function countUppercase($s): int
    {
        $cnt = 0;

        foreach (str_split($s) as $c) {
            if (ctype_upper($c)) {
                $cnt++;
            }
        }

        return $cnt;
    }

    function countNumbers($s): int
    {
        $cnt = 0;

        foreach (str_split($s) as $c) {
            if (ctype_digit($c)) {
                $cnt++;
            }
        }

        return $cnt;
    }

    function countPunctuation($s): int
    {
        $cnt = 0;

        foreach (str_split($s) as $c) {
            if (ctype_punct($c)) {
                $cnt++;
            }
        }

        return $cnt;
    }

    function sendConfirmationMail($audit) {
        $msg = new AuditReport($audit);
        Mail::to($audit -> auditor) -> send($msg);
    }


}
