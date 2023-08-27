export const http_build_query = function (params){
    const searchParameters = new URLSearchParams();

    Object.keys(params).forEach(function(param) {
        if(params[param])
        searchParameters.append(param, params[param]);
    });

    return searchParameters.toString();
}
