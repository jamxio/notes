<?php
/**
 * Created by PhpStorm.
 * User: jamxio
 * Date: 2018/9/6
 * Time: 10:11
 * mt_rand()的安全？大部分随机数生成都是同种同序列的
 * todo 为什么 mt_rand() 要被 random_int 替代？
 */
mt_srand();//播种
echo mt_rand();//随机数，同种同序列，爆破获得种子从而能推出序列，安全问题？应该不是很严重的吧
/**
 * 同种同序列生成随数很正常，为什么说出现安全问题呢。
 * @see http://wonderkun.cc/index.html/?p=585#comment-2003
 * 这个文章中有个 session_id 的问题我觉得说的不准确，清空cookie的phpSESSID，
 * 依然是会由 session_start 生成的吧
 */
