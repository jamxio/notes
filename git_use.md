# 初始化本地
`git init `
# 添加本地文件到版本控制
`git add . 目录路径 文件路径`
# 设置远程地址
`git remote add origin https://git地址`
## *或者用* `git clone https://git地址`可以直接将git库根目录创建到当前路径

# 合并两个不相关的仓库历史
` git pull origin master  --allow-unrelated-histories`
# 暂存与重做暂存
```sh
  git stash save 你的暂存名字
  git stash pop apply stask${0|1|2}

```
# 切换分支
`git checkout branch_name --`  
* #注意事项
> checkout 之前最好把修改commit一下或stash，否则有可能搞乱修改
