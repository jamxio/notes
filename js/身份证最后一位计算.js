let last = [1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2];//
let oNum = '44092419650403357';//十七位
let suiji = 1;
let S = 0;
let jj = require('./身份证区划').data;
suiji && (oNum = function () {
    function random(min, max) {
        return Math.floor(Math.random() * (max - min)) + min;
    }

    let num = '';
    let shengList = Object.keys(jj);
    let shengIndex = shengList[random(0, shengList.length)];
    num += shengIndex;
    let sheng = jj[shengIndex];
    let cityList = Object.keys(sheng.children);
    let cityIndex = cityList[random(0, cityList.length)];
    num += cityIndex;
    let city = sheng.children[cityIndex];
    let districtList = Object.keys(city.children);
    let districtIndex = districtList[random(0, districtList.length)];
    num += districtIndex;

    num += random(1900, (new Date).getFullYear()) + ('0' + random(1, 12)).slice(-2) + ('0' + random(1, 31)).slice(-2) + random(100, 999);
    return num;
}());
for (let i = 0; i < oNum.length; i++) {
    if (isNaN(parseInt(oNum[i])) || i > 16) {
        //错误
        break;
    }
    let bit = 18 - i;
    let W = 2 ** (bit - 1) % 11;
    S += W * oNum[i];
}
let Y = S % 11;
let code = last[Y];
console.log(oNum + code);
console.log(jj[oNum.substr(0, 2)]['pro'],
    jj[oNum.substr(0, 2)]['children'][oNum.substr(2, 2)]['city'],
    jj[oNum.substr(0, 2)]['children'][oNum.substr(2, 2)]['children'][oNum.substr(4, 2)]['county']);
