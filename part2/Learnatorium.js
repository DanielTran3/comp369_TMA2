
function InitListeners() {
    var addUnitButton = document.getElementById("addUnitButton");
    addUnitButton.addEventListener("click", function() {
        AddUnitButton_Click();
    });

    var createCourseButton = document.getElementById("createCourseButton");
    createCourseButton.addEventListener("createCourseButton", function() {

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
}