// tu su definovane spolocne response funkcie
// narozdiel od vue suborou je vsetko verejne exportovane

// vo vue treba kazdu funkciu importovat
//import { is404 } from "./../shared/utils/response";

export const is404 = function (err) {
    return isErrorWithResponseAndStatus(err) && err.response.status === 404;
};

export const is422 = function (err) {
    return isErrorWithResponseAndStatus && err.response.status === 422;
};

// toto je interna funkcia, ta sa pouziva len tu, neexportuje sa
const isErrorWithResponseAndStatus = function (err) {
    return err.response && err.response.status;
}