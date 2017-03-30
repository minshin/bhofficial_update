# Spot.IM Plugin for OctoberCMS

#### How to use

* Clone this repository to **plugins/namnv609/ocspotim** folder in your project
* Go to backend dashboard
* Click to **CMS** and open theme layout (*default.htm*)
* Click to **Components** > **Spot.IM** plugin then choose **Spot.IM**
* Click to **Spot.IM** plugin and insert your Spot.IM id to *ID* field.
* In *Markup* area, insert ``{% component 'spotim' %}`` in to last page. On ``</body>`` tags (or ``{{ scripts }}``) and Ctrl+S or click **Save**
* Open blog post page and choose **Comments** in **Spot.IM** component.
  * By default, component show unique comments for each post by post ID. You can change it in **Comments** setting. By select *No*, comments will available in all posts.
* Insert ``{% component 'spotimComment' potId=post.id %}`` to anywhere in *Markup* area and Ctrl+S or click **Save**
  * You must change *post.id* to correct variable in template markup
* Plugin also support count comments number by using **Replies count** in **Spot.IM**
  * To use **Replies count**, you need to insert ``{{ component 'spotimRepliesCount' postId=post.id }}`` to place you want. In **Replies count** has option **Counting text** for async result from Spot.IM. By default, counting text is **Counting...**!
