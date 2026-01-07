<form method="post" action="../../controller/notice_controller.php?action=store">
    Title: <input type="text" name="title"><br>
    Category: <input type="text" name="category"><br>
    Content: <textarea name="content"></textarea><br>
    Important: <input type="checkbox" name="is_important" value="1"><br>
    Expiry Date: <input type="date" name="expiry_date"><br>
    <input type="submit" value="Create">
</form>
