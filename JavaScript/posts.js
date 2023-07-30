/**
 * function to display search results when typed in
 * @param search
 */
function sendRequest(search) {
    var xmlhttp = new XMLHttpRequest();
    search = search.value;

    xmlhttp.open("GET", "../php/itemList.php?submitSearchJavaScript="+search, true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-formurlencoded");
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("item_list").innerHTML = this.responseText;
        }
    }
    xmlhttp.send();
}