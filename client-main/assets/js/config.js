const config = {
    baseApiUrl: "https://security-audit-server.test/api",
    organizationsEndpoint: "organizations",
    accountsEndpoint: "accounts",
    executeEndpoint: "execute_audit",
    token: "SECURE-IT",
}

function getOrganizationsUrl() {
    return `${config.baseApiUrl}/${config.organizationsEndpoint}`;
}
function getAccountsUrl() {
    return `${config.baseApiUrl}/${config.accountsEndpoint}`;
}
function getExecuteUrl() {
    return `${config.baseApiUrl}/${config.executeEndpoint}`;
}

function getToken() {
    return config.token;
}


export { getOrganizationsUrl, getExecuteUrl, getAccountsUrl, getToken };