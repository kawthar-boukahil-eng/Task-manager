const taskForm = document.getElementById("taskForm");
const taskList = document.getElementById("taskList");

taskForm.addEventListener("submit", function(e){

    e.preventDefault();

    // Get values
    const title = document.getElementById("taskTitle").value;
    const description = document.getElementById("taskDescription").value;
    const priority = document.getElementById("taskPriority").value;

    // Validation
    if(title === "" || description === "" || priority === ""){
        alert("Please fill all fields");
        return;
    }

    // Badge color
    let badgeColor = "";

    if(priority === "High"){
        badgeColor = "danger";
    }
    else if(priority === "Medium"){
        badgeColor = "warning";
    }
    else{
        badgeColor = "success";
    }

    // Create task card
    const taskCard = document.createElement("div");

    taskCard.classList.add(
        "card",
        "shadow",
        "p-3",
        "mb-3"
    );

    taskCard.innerHTML = `
    
        <div class="d-flex justify-content-between">

            <div>

                <h5>${title}</h5>

                <p class="text-muted">
                    ${description}
                </p>

            </div>

            <div>

                <span class="badge bg-${badgeColor}">
                    ${priority}
                </span>

                <button class="btn btn-sm btn-danger ms-2 delete-btn">
                    Delete
                </button>

            </div>

        </div>

    `;

    // Add task to list
    taskList.appendChild(taskCard);

    // Reset form
    taskForm.reset();

    // Delete task
    const deleteBtn = taskCard.querySelector(".delete-btn");

    deleteBtn.addEventListener("click", function(){

        taskCard.remove();

    });

});