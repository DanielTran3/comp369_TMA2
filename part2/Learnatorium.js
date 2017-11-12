
function InitListeners() {
    var addUnitButton = document.getElementById("addUnitButton");
    addUnitButton.addEventListener("click", function() {
        AddUnitButton_Click();
    });

    var createCourseButton = document.getElementById("createCourseButton");
    createCourseButton.addEventListener("click", function() {
        CreateCourseButton();
    });
}

function AddUnitButton_Click() {
    var courseDiv = document.getElementById("courseDiv");
    var unitDiv = document.createElement("div"); 
    unitDiv.classList.add("unitDiv");    
    var unitLabel = document.createElement("span");
    unitLabel.innerHTML = "Unit Name: ";
    var unitInput = document.createElement("input");
    unitInput.name = "unit[]";
    var numLessons = document.createElement("input");
    numLessons.hidden = true;
    numLessons.name = "numLessons[]";
    numLessons.value = 0;
    unitDiv.appendChild(unitLabel);
    unitDiv.appendChild(unitInput);
    unitDiv.appendChild(numLessons);

    var addLessonButton = document.createElement("button");
    addLessonButton.value = "AddLesson";
    addLessonButton.innerHTML = "Add Lesson";
    addLessonButton.type = "button";
    addLessonButton.addEventListener("click", function() {
        AddLessonButton_Click(unitDiv);
    });
    unitDiv.appendChild(addLessonButton);
    courseDiv.appendChild(unitDiv);
}

function AddLessonButton_Click(unitDiv) {
    var lessonDiv = document.createElement("div"); 
    lessonDiv.classList.add("lessonDiv");    
    var lessonLabel = document.createElement("span");
    lessonLabel.innerHTML = "Lesson Name: ";
    var lessonInput = document.createElement("input");
    lessonInput.name = "lesson[]";
    var lessonTextArea = document.createElement("textarea");
    lessonTextArea.name = "lessonEML[]";
    var numLessons = GetChildElementBasedOnName(unitDiv, "numLessons[]");
    numLessons.value = parseInt(numLessons.value) + 1;
    var quizLabel = document.createElement("span");
    quizLabel.innerHTML = "Quiz"
    var quizTextArea = document.createElement("textarea");
    quizTextArea.name = "quizEML[]";

    lessonDiv.appendChild(lessonLabel);
    lessonDiv.appendChild(lessonInput);
    lessonDiv.appendChild(lessonTextArea);
    lessonDiv.appendChild(quizLabel);
    lessonDiv.appendChild(quizTextArea);
    unitDiv.appendChild(lessonDiv);
}

function CreateCourseButton() {
    var courseName = document.getElementById("courseNameInput");
    courseName.value = courseName.value.replace(/'/g,"''");
    var unitNames = document.getElementsByName("unit[]");
    for (var i = 0; i < unitNames.length; i++) {
        unitNames[i].value = unitNames[i].value.replace(/'/g,"''");
    }
    var lessonNames = document.getElementsByName("lesson[]");
    for (var i = 0; i < lessonNames.length; i++) {
        lessonNames[i].value = lessonNames[i].value.replace(/'/g,"''");
    }
    var lessonEMLs = document.getElementsByName("lessonEML[]");
    for (var i = 0; i < lessonEMLs.length; i++) {
        lessonEMLs[i].value = lessonEMLs[i].value.replace(/'/g,"''");
        lessonEMLs[i].value = lessonEMLs[i].value.replace(/</g,"&lt;");
        lessonEMLs[i].value = lessonEMLs[i].value.replace(/>/g,"&gt;");
    }
    var quizEMLs = document.getElementsByName("quizEML[]");
    for (var i = 0; i < quizEMLs.length; i++) {
        quizEMLs[i].value = quizEMLs[i].value.replace(/'/g,"''");
        quizEMLs[i].value = quizEMLs[i].value.replace(/</g,"&lt;");
        quizEMLs[i].value = quizEMLs[i].value.replace(/>/g,"&gt;");
    }

}

//https://stackoverflow.com/questions/13656921/fastest-way-to-find-the-index-of-a-child-node-in-parent
function GetIndex(node) {
    var i=1;
    while(node.previousSibling){
        node = node.previousSibling;
        if(node.nodeType === 1){
            i++;
        }
    }
    return i;
}

function GetChildElementBasedOnName(divElem, elementName) {
    for (var i = 0; i < divElem.children.length; i++) {
        if (divElem.children[i].name === elementName) {
            return divElem.children[i];
        }
    }
}

function SelectACourse(course) {
    course.name="submittedCourse";
    var courseID = document.getElementsByName("courseId")[0];
    courseID.value = course.id;
}

function MarkQuiz(lessonID) {
    var totalCorrect = 0;
    var totalQuestions = 0;
    var quizDiv = document.getElementById(lessonID);
    var inputElements = quizDiv.getElementsByTagName("INPUT");
    for (var i = 0; i < inputElements.length; i++) {
        if (inputElements[i].type === "radio") {
            if (inputElements[i].getAttribute("correct") === "*") {
                totalQuestions++;
                if (inputElements[i].checked) {
                    totalCorrect++;
                }
            }
        }
    }
    if (document.getElementById("finalScore" + lessonID) === null) {
        var finalScore = document.createElement("h3");
        finalScore.id = "finalScore" + lessonID;
        finalScore.style.styleFloat = 'right';
        finalScore.style.cssFloat = 'right';
        quizDiv.appendChild(finalScore);
    }
    var finalScore = document.getElementById("finalScore" + lessonID);
    finalScore.innerHTML = "Final Score: " + totalCorrect + "/" + totalQuestions + 
                           " | " + ((totalCorrect/totalQuestions) * 100).toFixed(2) + "%";
}

function SelectCourse(course) {
    var prevSelectedCourses = document.getElementsByClassName("availableCourse");
    for (var i = 0; i < prevSelectedCourses.length; i++) {
        prevSelectedCourses[i].classList.remove("selectedCourse");
    }
    course.classList.add("selectedCourse");
    var addCourseInput = document.getElementById("addCourseID");
    addCourseInput.value = course.id;
}