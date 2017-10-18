var selectedBookmark;

function initListeners() {
    var addButton = document.getElementById("addBookmarkButton");
    var editButton = document.getElementById("editBookmarkButton");
    var deleteButton = document.getElementById("deleteBookmarkButton");

    addButton.addEventListener("click", function(e) {
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
    var newBookmarkTextBox = document.getElementById("newBookmarkTextBox");
    var newBookmarkNameTextBox = document.getElementById("newBookmarkNameTextBox").value;
    var urlString = newBookmarkTextBox.value;    
    var expression = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,4}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g;
    var regex = new RegExp(expression);
    
    var invalidURL = document.getElementById("invalidURL");
    var inactiveURL = document.getElementById("inactiveURL");
    if (urlString.match(regex)) {
        var request = new XMLHttpRequest();  
        urlExists(urlString, function(exists) {
            if (exists) {
                invalidURL.hidden = true;
                inactiveURL.hidden = true;
                newBookmarkTextBox.style.borderColor = "black";
                $.ajax({
                    type: "POST",
                    url: 'AddBookmark.php',
                    data: { newBookmarkURL: urlString, newBookmarkName: newBookmarkNameTextBox },
                    complete: function (response) {
                        // alert("Bookmark Added");
                        location.reload();
                    },
                    error: function() {
                        alert("Error Adding Bookmark");
                    }
                });
            }
            else {
                invalidURL.hidden = true;
                inactiveURL.hidden = false;
            }
        });
    }

    else {
        inactiveURL.hidden = true;
        invalidURL.hidden = false;        
        newBookmarkTextBox.style.borderColor = "red";
    }
}

function EditBookmark() {
    var _oldBookmarkName = document.getElementsByName("oldBookmarkName")[0];
    var _oldBookmarkURL = document.getElementsByName("oldBookmarkURL")[0];
    // oldBookmarkName.value = bookmark.children[0].innerHTML;
    // oldBookmarkURL.value = bookmark.children[0].attributes[0].nodeValue;


    var _editedBookmarkName = document.getElementsByName("editedBookmarkName")[0];
    var _editedBookmarkURL = document.getElementsByName("editedBookmarkURL")[0];
    _editedBookmarkName.value = document.getElementById("newBookmarkNameTextBox").value;
    _editedBookmarkURL.value = document.getElementById("newBookmarkTextBox").value;

    var newBookmarkTextBox = document.getElementById("newBookmarkTextBox");
    var newBookmarkNameTextBox = document.getElementById("newBookmarkNameTextBox").value;
    var urlString = _editedBookmarkURL.value;    
    var expression = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,4}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g;
    var regex = new RegExp(expression);
    
    var invalidURL = document.getElementById("invalidURL");
    var inactiveURL = document.getElementById("inactiveURL");
    if (urlString.match(regex)) {
        var request = new XMLHttpRequest();  
        urlExists(urlString, function(exists) {
            if (exists) {
                invalidURL.hidden = true;
                inactiveURL.hidden = true;
                newBookmarkTextBox.style.borderColor = "black";
                $.ajax({
                    type: "POST",
                    url: 'EditBookmark.php',
                    data: { editedBookmarkURL: _editedBookmarkURL, editedBookmarkName: _editedBookmarkName,
                            oldBookmarkURL: _oldBookmarkURL, oldBookmarkName: _oldBookmarkName },
                    complete: function (response) {
                        alert("Bookmark Added");
                        location.reload();
                    },
                    error: function() {
                        alert("Error Adding Bookmark");
                    }
                });
            }
            else {
                invalidURL.hidden = true;
                inactiveURL.hidden = false;
            }
        });
    }

    else {
        inactiveURL.hidden = true;
        invalidURL.hidden = false;        
        newBookmarkTextBox.style.borderColor = "red";
    }
}

function DeleteBookmark() {

}

function VerifyURL() {
    var newBookmarkTextBox = document.getElementById("newBookmarkTextBox");
    var newBookmarkNameTextBox = document.getElementById("newBookmarkNameTextBox").value;
    var urlString = newBookmarkTextBox.value;    
    var expression = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,4}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g;
    var regex = new RegExp(expression);
    
    var invalidURL = document.getElementById("invalidURL");
    var inactiveURL = document.getElementById("inactiveURL");
    if (urlString.match(regex)) {
        var request = new XMLHttpRequest();  
        urlExists(urlString, function(exists) {
            if (exists) {
                invalidURL.hidden = true;
                inactiveURL.hidden = true;
                newBookmarkTextBox.style.borderColor = "black";
                $.ajax({
                    type: "POST",
                    url: 'AddBookmark.php',
                    data: { newBookmarkURL: urlString, newBookmarkName: newBookmarkNameTextBox },
                    complete: function (response) {
                         alert("Bookmark Added");
                        location.reload();
                    },
                    error: function() {
                        alert("Error Adding Bookmark");
                    }
                });
            }
            else {
                invalidURL.hidden = true;
                inactiveURL.hidden = false;
                e.preventDefault();
            }
        });
    }

    else {
        inactiveURL.hidden = true;
        invalidURL.hidden = false;        
        newBookmarkTextBox.style.borderColor = "red";
    }
}

function urlExists(urlString, callback) {
    $.ajax({
        type: 'HEAD',
        url: "http://cors-anywhere.herokuapp.com/" + urlString,
        success: function() {
            callback(true);
        },
        error: function() {
            callback(false);
        }
    });
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