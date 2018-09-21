let n = 0;
let m = 0;
let monster;

config(10000, 3000);
randMonster();
let attackHp = betterAttack();
let defendHp = betterDefend();
let maxHp = Math.max(attackHp,defendHp);
console.log('小茗加了'+maxHp);

function debug(str) {
    console.error(str);
}

function back(str) {
    console.info(str);
}

/**
 * 设置怪物数量与小茗的能量
 * @param monster
 * @param xiaoming
 */
function config(monster, xiaoming) {
    let newN = parseInt(monster);
    let newM = parseInt(xiaoming);
    if (isNaN(newN) || newN <= 0) return debug('请输入正确的怪物数量，大于0');
    if (isNaN(newM) || newM <= 0 || newM >= newN) return debug('请输入正确的小茗能量，大于0，小于怪物总量');
    n = newN;
    m = newM;
}

/**
 * 召唤怪兽
 * @param newMonster
 */
function callMonster(newMonster) {
    if (n === 0) return debug('请先设置怪物数量！');
    if (typeof newMonster !== "string" || newMonster.length != n || newMonster.search(/[^AD]/i) >= 0)
        return debug('请召唤正确的怪兽天团，' + n + '长度的AD自由组合');
    monster = newMonster;
    back('数量' + n + '的怪兽天团：' + monster + '出现了');
}

/**
 * 随便阵型的怪兽天团
 */
function randMonster() {
    if (n === 0) return debug('请先设置怪物数量！');
    let type = 'AD';
    let team = '';
    let numMonster = n;
    while (numMonster-- > 0) {
        team += type[Math.round(Math.random())];
    }
    return callMonster(team);
}

/**
 * 尝试从i开始攻击怪兽
 * @param i
 */
function tryAttack(i) {
    if (i > n - m || i < 0) {
        return debug('小茗攻击位置错了，会浪费能量');
    }
    let hp = 0;
    for (let j = i, restM = m; j < n; j++, hp++) {
        if (monster[j] === 'A') {
            restM--;
        }
        if (restM === 0) {
            break;
        }
    }
    back('从第' + (i + 1) + '个怪兽开始攻击，恢复了' + hp);
    return hp;
}

/**
 * 尝试从i开始抵御怪兽
 * @param i
 * @returns {*}
 */
function tryDefend(i) {
    if (i > n - m || i < 0) {
        return debug('小茗抵御位置错了，会浪费能量');
    }
    let hp = 0;
    for (let j = i, restM = m; j < n; j++, hp++) {
        if (monster[j] === 'D') {
            restM--;
        }
        if (restM === 0) {
            break;
        }
    }
    back('抵御了从第' + (i + 1) + '个怪兽的攻击，恢复了' + hp);
    return hp;
}

/**
 *  最好的攻击收成
 * @returns {number}
 */
function betterAttack() {
    let betterHp = 0;
    for (let i = 0; i <= n - m; i++) {
        let tryHp = tryAttack(i);
        betterHp < tryHp && (betterHp = tryHp);
    }
    back('最好的攻击收成是' + betterHp);
    return betterHp;
}

/**
 * 最好的防御收成
 * @returns {number}
 */
function betterDefend() {
    let betterHp = 0;
    for (let i = 0; i <= n - m; i++) {
        let tryHp = tryDefend(i);
        betterHp < tryHp && (betterHp = tryHp);
    }
    back('最好的防御收成是' + betterHp);
    return betterHp;
}