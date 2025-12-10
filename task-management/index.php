<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Task Management System</h1>
            <div id="userInfo"></div>
        </header>

        <div id="loginSection" class="section">
            <h2>Login</h2>
            <form id="loginForm">
                <div class="form-group">
                    <input type="text" id="loginUsername" placeholder="Username" required>
                    <span class="error-msg" id="loginUsernameError"></span>
                </div>
                <div class="form-group">
                    <input type="password" id="loginPassword" placeholder="Password" required>
                    <span class="error-msg" id="loginPasswordError"></span>
                </div>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="#" id="showRegister">Register</a></p>
        </div>

        <div id="registerSection" class="section hidden">
            <h2>Register</h2>
            <form id="registerForm">
                <div class="form-group">
                    <input type="text" id="regUsername" placeholder="Username (3-20 characters)" required>
                    <span class="error-msg" id="regUsernameError"></span>
                </div>
                <div class="form-group">
                    <input type="email" id="regEmail" placeholder="Email" required>
                    <span class="error-msg" id="regEmailError"></span>
                </div>
                <div class="form-group">
                    <input type="password" id="regPassword" placeholder="Password (min 6 characters)" required>
                    <span class="error-msg" id="regPasswordError"></span>
                </div>
                <div class="form-group">
                    <input type="password" id="regConfirmPassword" placeholder="Confirm Password" required>
                    <span class="error-msg" id="regConfirmPasswordError"></span>
                </div>
                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="#" id="showLogin">Login</a></p>
        </div>

        <div id="taskSection" class="section hidden">
            <div class="task-header">
                <h2>My Tasks</h2>
                <button id="logoutBtn">Logout</button>
            </div>
            
            <div class="add-task">
                <h3>Add New Task</h3>
                <form id="taskForm">
                    <div class="form-group">
                        <input type="text" id="taskTitle" placeholder="Task Title (3-200 characters)" required>
                        <span class="error-msg" id="taskTitleError"></span>
                    </div>
                    <div class="form-group">
                        <textarea id="taskDescription" placeholder="Task Description (5-1000 characters)" required></textarea>
                        <span class="error-msg" id="taskDescriptionError"></span>
                    </div>
                    <div class="form-group">
                        <select id="taskPriority">
                            <option value="low">Low Priority</option>
                            <option value="medium">Medium Priority</option>
                            <option value="high">High Priority</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="date" id="taskDueDate" required>
                        <span class="error-msg" id="taskDueDateError"></span>
                    </div>
                    <button type="submit">Add Task</button>
                </form>
            </div>

            <div class="filter-section">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="pending">Pending</button>
                <button class="filter-btn" data-filter="completed">Completed</button>
            </div>

            <div id="taskList" class="task-list"></div>
        </div>
    </div>

    <script src="js/app.js"></script>
</body>
</html>
