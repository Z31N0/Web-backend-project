import { getOrganizationsUrl } from "../config.js";
import { fetchFromServer } from "../util/fetcher.js";
import { renderOrganizations } from "./renderer.js";

function loadOrganizations() {
    fetchFromServer(getOrganizationsUrl(), "GET")
        .then(json => renderOrganizations(json.data))
        .catch(err => console.error(err));
}

function selectOrganization(e) {
    e.preventDefault();
    // TODO
}

function getAuditorEmail(){
    // TODO
}

export { loadOrganizations };