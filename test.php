<?php require_once 'core/core.php'; ?>
<html>

    <head>
        <title>Creo un SITO WEB da Zero #08 ⋆ ESEMPIO di BACK-END (custom)</title>
    </head>

    <body>
        <?php if (!$USER) : ?>
            <h1>LOGIN</h1>
            <form method="POST">
                <input type="text" name="username" placeholder="username">
                <input type="password" name="password" placeholder="password">
                <input type="submit" value="LOGIN">
            </form>
        <?php else : ?>
            <h1>LOGOUT</h1>
            <form method="POST">
                <?php echo $USER->username; ?>
                (<span><?php echo $USER->role; ?></span>)
                <input type="hidden" name="logout">
                <input type="submit" value="LOGOUT">
            </form>

            <hr/>

            <h1>TAG</h1>
            <form method="GET" action="/tutorial/ep8/rest/getalltags.php">
                <input type="submit" value="GET ALL TAGS">
            </form>

            <br/>

            <form method="POST" action="/tutorial/ep8/rest/addtag.php">
                <input type="text" name="tag" placeholder="tag">
                <input type="submit" value="ADD TAG">
            </form>

            <br/>

            <form method="POST" action="/tutorial/ep8/rest/deletetag.php">
                <input type="number" name="tag" placeholder="tag id">
                <input type="submit" value="DELETE TAG">
            </form>

            <br/>

            <form method="POST" action="/tutorial/ep8/rest/edittag.php">
                <input type="number" name="id" placeholder="tag id">
                <input type="text" name="tag" placeholder="tag">
                <input type="number" name="weight" placeholder="tag weight">
                <input type="submit" value="EDIT TAG">
            </form>

            <hr/>

            <h1>CATEGORY</h1>
            <form method="GET" action="/tutorial/ep8/rest/getcategories.php">
                <input type="number" name="offset" placeholder="offset">
                <input type="submit" value="GET CATEGORIES">
            </form>

            <br/>

            <form enctype="multipart/form-data" method="POST" action="/tutorial/ep8/rest/addcategory.php">
                <input type="text" name="title" placeholder="title">
                <textarea name="description" placeholder="description"></textarea>
                <input type="file" name="file" placeholder="cover">
                <input type="submit" value="ADD CATEGORY">
            </form>

            <br/>

            <form method="POST" action="/tutorial/ep8/rest/deletecategory.php">
                <input type="number" name="category" placeholder="category id">
                <input type="submit" value="DELETE CATEGORY">
            </form>

            <br/>

            <form enctype="multipart/form-data" method="POST" action="/tutorial/ep8/rest/editcategory.php">
                <input type="number" name="id" placeholder="category id">
                <input type="text" name="title" placeholder="title">
                <textarea name="description" placeholder="description"></textarea>
                <input type="file" name="file" placeholder="cover">
                <input type="submit" value="EDIT CATEGORY">
            </form>

            <hr/>

            <h1>POST</h1>
            <form method="GET" action="/tutorial/ep8/rest/getlatestpostsbycategory.php">
                <input type="text" name="p" placeholder="category permalink">
                <input type="submit" value="GET LATEST POSTS by CATEGORY PERMALINK">
            </form>

            <br/>

            <form method="GET" action="/tutorial/ep8/rest/getpostbypermalink.php">
                <input type="text" name="p" placeholder="post permalink">
                <input type="submit" value="GET POST by PERMALINK">
            </form>

            <br/>

            <form method="GET" action="/tutorial/ep8/rest/getpostsbytag.php">
                <input type="text" name="t" placeholder="tag permalink">
                <input type="number" name="offset" placeholder="offset">
                <input type="submit" value="GET 5 POSTS by TAG PERMALINK">
            </form>

            <br/>

            <form method="GET" action="/tutorial/ep8/rest/getpostssummaries.php">
                <input type="number" name="offset" placeholder="offset">
                <input type="submit" value="GET 5 POST">
            </form>

            <br/>

            <form method="POST" action="/tutorial/ep8/rest/addpost.php">
                <input type="text" name="title" placeholder="title">
                <textarea name="summary" placeholder="summary"></textarea>
                <textarea name="content" placeholder="content"></textarea>
                <select name="tags[]" multiple>
                    <option value="tag-1">tag-1</option>
                    <option value="tag-2">tag-2</option>
                    <option value="tag-3">tag-3</option>
                </select>
                <select name="categories[]" multiple>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
                <input type="submit" value="ADD POST">
            </form>

            <br/>

            <form method="POST" action="/tutorial/ep8/rest/deletepost.php">
                <input type="number" name="post" placeholder="post id">
                <input type="submit" value="DELETE POST">
            </form>

            <br/>

            <form method="POST" action="/tutorial/ep8/rest/editpost.php">
                <input type="number" name="id" placeholder="post id">
                <input type="text" name="title" placeholder="title">
                <textarea name="summary" placeholder="summary"></textarea>
                <textarea name="content" placeholder="content"></textarea>
                <select name="tags[]" multiple>
                    <option value="tag-1">tag-1</option>
                    <option value="tag-2">tag-2</option>
                    <option value="tag-3">tag-3</option>
                </select>
                <select name="categories[]" multiple>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
                <input type="submit" value="EDIT POST">
            </form>

            <hr/>

            <h1>ROLE (admin only)</h1>
            <form method="POST" action="/tutorial/ep8/rest/addrole.php">
                <input type="text" name="role" placeholder="role">
                <input type="submit" value="ADD ROLE">
            </form>

            <br/>

            <form method="POST" action="/tutorial/ep8/rest/deleterole.php">
                <input type="number" name="role" placeholder="role id">
                <input type="submit" value="DELETE ROLE">
            </form>

            <br/>

            <form method="POST" action="/tutorial/ep8/rest/editrole.php">
                <input type="number" name="id" placeholder="role id">
                <input type="text" name="role" placeholder="role">
                <input type="submit" value="EDIT ROLE">
            </form>

            <hr/>

            <h1>USER (admin only)</h1>
            <form method="POST" action="/tutorial/ep8/rest/adduser.php">
                <input type="text" name="username" placeholder="username">
                <input type="password" name="password" placeholder="password">
                <input type="number" name="role" placeholder="role id">
                <input type="submit" value="ADD USER">
            </form>

            <br/>

            <form method="POST" action="/tutorial/ep8/rest/deleteuser.php">
                <input type="number" name="user" placeholder="user id">
                <input type="submit" value="DELETE USER">
            </form>

            <br/>

            <form method="POST" action="/tutorial/ep8/rest/edituser.php">
                <input type="number" name="id" placeholder="user id">
                <input type="text" name="username" placeholder="username">
                <input type="password" name="password" placeholder="password">
                <input type="number" name="role" placeholder="role id">
                <input type="submit" value="EDIT USER">
            </form>

            <hr/>
            
            <h1>MESSAGES</h1>
            <form method="GET" action="/tutorial/ep8/rest/getmessages.php">
                <input type="number" name="offset" placeholder="offset">
                <input type="submit" value="GET LATEST MESSAGES">
            </form>

            <br/>
            
            <form method="POST" action="/tutorial/ep8/rest/addmessage.php">
                <input type="text" name="title" placeholder="title">
                <textarea name="text" placeholder="text"></textarea>
                <input type="submit" value="ADD MESSAGE">
            </form>

            <br/>

            <form method="POST" action="/tutorial/ep8/rest/deletemessage.php">
                <input type="number" name="message" placeholder="message id">
                <input type="submit" value="DELETE MESSAGE">
            </form>

            <br/>

        <?php endif; ?>
    </body>

</html>
<?php require_once 'core/shutdown.php'; ?>