let last = [1,0,'X',9,8,7,6,5,4,3,2];//
let oNum = '12456488464548752';//十七位
let S = 0;
for(let i=0;i<oNum.length;i++){
    if(isNaN(parseInt(oNum[i]))){
        //错误
        break;
    }
    let bit = 18-i;
    let W = 2**(bit-1)%11;
    S += W*oNum[i];
}
let Y = S%11;
let code = last[Y];
console.log(oNum+code);