//利用拦截器，统一请求异常的响应操作
window.axios = require('axios');
axios.interceptors.response.use((response) => {
    //这个是请求成功得回调闭包，即200 http status
    return response;
}, function (err) {
    console.log(err.response.status + '是http请求返回的状态码');
    return Promise.reject(err);
});