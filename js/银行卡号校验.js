let iniCard = '621483213234567';

let binCode = iniCard.substr(0, 6);

let binLib = [];

function lastCode(cardNo) {
    let sum = 0;
    let cnoLength = cardNo.length;
    for (let i = 0; i < cnoLength; i++) {
        //注意奇偶位以右到左为参考
        if ((cnoLength - i) % 2 === 0) { // 偶数位
            sum += parseInt(cardNo[i]);
        } else {
            let dNo = parseInt(cardNo[i]) * 2;
            sum += parseInt(dNo / 10) + (dNo % 10);
        }
    }
    let rest = sum % 10;
    return rest===0?0:10-rest;
}

let wholeCard = iniCard + lastCode(iniCard);
console.log(wholeCard);
