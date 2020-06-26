如你所见，魔改版Typecho，加了一堆我喜欢的东西，取名为Casual-log。

以下是我做的魔改：

1.更换了后台主题

2.轻度魔改安装过程，应该是更方便、快速了（bushi）

3.默认不启用Antispam，毕竟众所周知，Typecho自带的往往没屌用

4.文章被设置为私密/密码访问的时候，将显示标题

5.加长description字段，将利于SEO

6.去掉没屌用的更新和后台欢迎

7.默认支持文章置顶功能

8.外链自动添加nofollow属性

9.外链自动在新标签打开

10.增加按评论数排序，随机排序，按字数排序文章的接口，调用示例：

按评论数排序

>  <?php $this->widget('Widget_Contents_Post_Comments','pageSize=10')->to($Comments);while($Comments->next()): ?>


> <?php endwhile; ?>

随机排序

> <?php $this->widget('Widget_Contents_Post_Rand','pageSize=10')->to($Rand);while($Rand->next()): ?>


> <?php endwhile; ?>

按字数排序

> <?php $this->widget('Widget_Contents_Post_Size','pageSize=10')->to($Size);while($Size->next()): ?>


> <?php endwhile; ?>