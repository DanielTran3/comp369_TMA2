var selectedBookmark;

function initListeners() {
    var addButton = document.getElementById("addBookmarkButton");
    var editButton = document.getElementById("editBookmarkButton");
    var deleteButton = document.getElementById("deleteBookmarkButton");

    addButton.addEventListener("click", function() {
        AddBookmark();
    });
    editButton.addEventListener("click", function() {
        EditBookmark();
    });
    deleteButton.addEventListener("click", function() {
        DeleteBookmark();
    });
}

function AddBookmark() {

    // var bookmarkDiv = document.getElementById("bookmarkDiv");
    // var newBookmarkDiv = document.createElement("div");
    // newBookmarkDiv.id = "newBookmarkDiv";
    // newBookmarkDiv.className += "innerDiv";
    
    // var newBookmarkTextBox = document.createElement("input");
    // newBookmarkTextBox.id = "newBookmarkTextBox";
    // newBookmarkTextBox.type = "text";
    // newBookmarkTextBox.name = "newBookmark";
    // newBookmarkTextBox.className += "floatLeft";
    // newBookmarkTextBox.className += " largeInputBox";

    // var newBookmarkButton = document.createElement("button");
    // newBookmarkButton.id = "newBookmarkButton";
    // newBookmarkButton.className += "whiteButton";
    // newBookmarkButton.style.marginTop = "0px";
    // newBookmarkButton.innerHTML = "Add";
    // newBookmarkButton.addEventListener("click", function() {
    //     StoreBookmark(newBookmarkTextBox.value);
    // });

    // newBookmarkDiv.appendChild(newBookmarkTextBox);
    // newBookmarkDiv.appendChild(newBookmarkButton);
    // bookmarkDiv.appendChild(newBookmarkDiv);
}

function StoreBookmark(urlString) {
    // var request;
    // if(window.XMLHttpRequest)
    //     request = new XMLHttpRequest();
    // else
    //     request = new ActiveXObject("Microsoft.XMLHTTP");
    // request.open('GET', urlString, false);
    // request.send(); // there will be a 'pause' here until the response to come.
    // // the object request will be actually modified
    // if (request.status === 404) {
    //     alert("didn't work");
    //     var newBookmarkTextBox = document.getElementById("newBookmarkTextBox");
    //     if (!newBookmarkTextBox.classList.contains("errorTextBox")) {
    //         newBookmarkTextBox.className += " errorTextBox";
    //     }
    // }
    // else {
    //     alert("worked");
    //     var bookmarkDiv = document.getElementById("bookmarkDiv");
    //     bookmarkDiv.removeChild(document.getElementById("newBookmarkDiv"));
    // }
        $.post("AddBookmark.php");
    // $.ajax({
    //     type: 'HEAD',
    //     url: urlString,
    //     success: function() {
    //         var bookmarkDiv = document.getElementById("bookmarkDiv");
    //         bookmarkDiv.removeChild(document.getElementById("newBookmarkDiv"));
    //     },
    //     error: function() {
    //         var newBookmarkTextBox = document.getElementById("newBookmarkTextBox");
    //         if (!newBookmarkTextBox.classList.contains("errorTextBox")) {
    //             newBookmarkTextBox.className += "errorTextBox";
    //         }
    //     }
    // });
}

function EditBookmark() {
    var oldBookmarkName = document.getElementsByName("oldBookmarkName")[0];
    var oldBookmarkURL = document.getElementsByName("oldBookmarkURL")[0];
    // oldBookmarkName.value = bookmark.children[0].innerHTML;
    // oldBookmarkURL.value = bookmark.children[0].attributes[0].nodeValue;


    var editedBookmarkName = document.getElementsByName("editedBookmarkName")[0];
    var editedBookmarkURL = document.getElementsByName("editedBookmarkURL")[0];
    editedBookmarkName.value = document.getElementById("newBookmarkNameTextBox").value;
    editedBookmarkURL.value = document.getElementById("newBookmarkTextBox").value;
}

function DeleteBookmark() {

}

function SelectBookmark(bookmark) {
    var prevSelectedBookmark = document.getElementsByClassName("selectedBookmark");
    for (var i = 0; i < prevSelectedBookmark.length; i++) {
        prevSelectedBookmark[i].className -= " selectedBookmark";
    }
    bookmark.className += " selectedBookmark";

    var oldBookmarkName = document.getElementsByName("oldBookmarkName")[0];
    var oldBookmarkURL = document.getElementsByName("oldBookmarkURL")[0];

    var bookmarkNameToDelete = document.getElementsByName("bookmarkNameToDelete")[0];
    var bookmarkURLToDelete = document.getElementsByName("bookmarkURLToDelete")[0];

    oldBookmarkName.value = bookmark.children[0].innerHTML;
    oldBookmarkURL.value = bookmark.children[0].attributes[0].nodeValue;

    bookmarkNameToDelete.value = bookmark.children[0].innerHTML;
    bookmarkURLToDelete.value = bookmark.children[0].attributes[0].nodeValue;
}

function OpenURL(url) {
    var urlString = url.attributes[0].nodeValue;
    var newTab = window.open(urlString, '_blank');
    newTab.focus();
}