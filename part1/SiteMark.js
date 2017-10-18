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
    // newBookmarkDiv.classList.add("innerDiv";
    
    // var newBookmarkTextBox = document.createElement("input");
    // newBookmarkTextBox.id = "newBookmarkTextBox";
    // newBookmarkTextBox.type = "text";
    // newBookmarkTextBox.name = "newBookmark";
    // newBookmarkTextBox.classList.add("floatLeft";
    // newBookmarkTextBox.classList.add(" largeInputBox";

    // var newBookmarkButton = document.createElement("button");
    // newBookmarkButton.id = "newBookmarkButton";
    // newBookmarkButton.classList.add("whiteButton";
    // newBookmarkButton.style.marginTop = "0px";
    // newBookmarkButton.innerHTML = "Add";
    // newBookmarkButton.addEventListener("click", function() {
    //     StoreBookmark(newBookmarkTextBox.value);
    // });

    // newBookmarkDiv.appendChild(newBookmarkTextBox);
    // newBookmarkDiv.appendChild(newBookmarkButton);
    // bookmarkDiv.appendChild(newBookmarkDiv);
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

function VerifyURL() {
    var mainDiv = document.getElementById("mainDiv");
    var newBookmarkTextBox = document.getElementById("newBookmarkTextBox");
    var urlString = newBookmarkTextBox.value;    
    var expression = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,4}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g;
    var regex = new RegExp(expression);
    
    var errorText = document.getElementById("invalidURL");
    if (urlString.match(regex)) {
        errorText.hidden = true;
        newBookmarkTextBox.style.borderColor = "black";        
        return true;
    }

    else {
        errorText.hidden = false;        
        newBookmarkTextBox.style.borderColor = "red";
        return false;
    }
}

function SelectBookmark(bookmark) {
    var prevSelectedBookmark = document.getElementsByClassName("selectedBookmark");
    for (var i = 0; i < prevSelectedBookmark.length; i++) {
        prevSelectedBookmark[i].classList.remove("selectedBookmark");
    }
    bookmark.classList.add("selectedBookmark");

    var oldBookmarkName = document.getElementsByName("oldBookmarkName")[0];
    var oldBookmarkURL = document.getElementsByName("oldBookmarkURL")[0];

    var bookmarkNameToDelete = document.getElementsByName("bookmarkNameToDelete")[0];
    var bookmarkURLToDelete = document.getElementsByName("bookmarkURLToDelete")[0];

    oldBookmarkName.value = bookmark.children[0].innerHTML;
    oldBookmarkURL.value = bookmark.children[0].attributes[0].nodeValue;

    bookmarkNameToDelete.value = bookmark.children[0].innerHTML;
    bookmarkURLToDelete.value = bookmark.children[0].attributes[0].nodeValue;

    var newBookmarkNameTextBox = document.getElementById("newBookmarkNameTextBox");
    var newBookmarkTextBox = document.getElementById("newBookmarkTextBox");

    newBookmarkNameTextBox.value = bookmark.children[0].innerHTML;
    newBookmarkTextBox.value = bookmark.children[0].attributes[0].nodeValue;
}

function OpenURL(url) {
    var urlString = url.attributes[0].nodeValue;

    $.ajax({
        type: "POST",
        url: 'UpdateHit.php',
        data: { url: urlString },
        complete: function (response) {
        },
        error: function() {
            alert("Error Updating Hit");
        }
    });

    var newTab = window.open(urlString, '_blank');
    newTab.focus();
}