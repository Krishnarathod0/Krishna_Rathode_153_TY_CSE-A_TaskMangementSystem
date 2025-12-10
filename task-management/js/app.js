// DOM Elements
const loginSection = document.getElementById('loginSection');
const registerSection = document.getElementById('registerSection');
const taskSection = document.getElementById('taskSection');
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');
const taskForm = document.getElementById('taskForm');
const taskList = document.getElementById('taskList');
const userInfo = document.getElementById('userInfo');

// Navigation
document.getElementById('showRegister').addEventListener('click', (e) => {
    e.preventDefault();
    loginSection.classList.add('hidden');
    registerSection.classList.remove('hidden');
});

document.getElementById('showLogin').addEventListener('click', (e) => {
    e.preventDefault();
    registerSection.classList.add('hidden');
    loginSection.classList.remove('hidden');
});

// Check if user is logged in
checkAuth();

function checkAuth() {
    fetch('php/check_auth.php')
        .then(res => res.json())
        .then(data => {
            if (data.loggedIn) {
                showTaskSection(data.username);
                loadTasks();
            }
        });
}

// Validation Functions
function validateUsername(username) {
    if (username.length < 3) {
        return 'Username must be at least 3 characters';
    }
    if (username.length > 20) {
        return 'Username must not exceed 20 characters';
    }
    if (!/^[a-zA-Z0-9_]+$/.test(username)) {
        return 'Username can only contain letters, numbers, and underscores';
    }
    return '';
}

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        return 'Please enter a valid email address';
    }
    return '';
}

function validatePassword(password) {
    if (password.length < 6) {
        return 'Password must be at least 6 characters';
    }
    if (password.length > 50) {
        return 'Password must not exceed 50 characters';
    }
    return '';
}

function clearErrors() {
    document.querySelectorAll('.error-msg').forEach(el => el.textContent = '');
    document.querySelectorAll('input').forEach(el => el.classList.remove('input-error'));
}

function showError(inputId, errorId, message) {
    document.getElementById(inputId).classList.add('input-error');
    document.getElementById(errorId).textContent = message;
}

// Register
registerForm.addEventListener('submit', (e) => {
    e.preventDefault();
    clearErrors();

    const username = document.getElementById('regUsername').value.trim();
    const email = document.getElementById('regEmail').value.trim();
    const password = document.getElementById('regPassword').value;
    const confirmPassword = document.getElementById('regConfirmPassword').value;

    let hasError = false;

    // Validate username
    const usernameError = validateUsername(username);
    if (usernameError) {
        showError('regUsername', 'regUsernameError', usernameError);
        hasError = true;
    }

    // Validate email
    const emailError = validateEmail(email);
    if (emailError) {
        showError('regEmail', 'regEmailError', emailError);
        hasError = true;
    }

    // Validate password
    const passwordError = validatePassword(password);
    if (passwordError) {
        showError('regPassword', 'regPasswordError', passwordError);
        hasError = true;
    }

    // Validate confirm password
    if (password !== confirmPassword) {
        showError('regConfirmPassword', 'regConfirmPasswordError', 'Passwords do not match');
        hasError = true;
    }

    if (hasError) return;

    fetch('php/register.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, email, password })
    })
    .then(res => res.json())
    .then(data => {
        showMessage(data.message, data.success ? 'success' : 'error', registerSection);
        if (data.success) {
            registerForm.reset();
            setTimeout(() => {
                registerSection.classList.add('hidden');
                loginSection.classList.remove('hidden');
            }, 1500);
        }
    });
});

// Login
loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    clearErrors();

    const username = document.getElementById('loginUsername').value.trim();
    const password = document.getElementById('loginPassword').value;

    let hasError = false;

    // Validate username
    if (username.length === 0) {
        showError('loginUsername', 'loginUsernameError', 'Username is required');
        hasError = true;
    }

    // Validate password
    if (password.length === 0) {
        showError('loginPassword', 'loginPasswordError', 'Password is required');
        hasError = true;
    }

    if (hasError) return;

    fetch('php/login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password })
    })
    .then(res => res.json())
    .then(data => {
        showMessage(data.message, data.success ? 'success' : 'error', loginSection);
        if (data.success) {
            loginForm.reset();
            setTimeout(() => {
                showTaskSection(username);
                loadTasks();
            }, 1000);
        }
    });
});

// Logout
document.getElementById('logoutBtn').addEventListener('click', () => {
    fetch('php/logout.php')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                taskSection.classList.add('hidden');
                loginSection.classList.remove('hidden');
                loginForm.reset();
            }
        });
});

// Add Task
taskForm.addEventListener('submit', (e) => {
    e.preventDefault();
    clearErrors();

    const title = document.getElementById('taskTitle').value.trim();
    const description = document.getElementById('taskDescription').value.trim();
    const priority = document.getElementById('taskPriority').value;
    const dueDate = document.getElementById('taskDueDate').value;

    let hasError = false;

    // Validate title
    if (title.length < 3) {
        showError('taskTitle', 'taskTitleError', 'Title must be at least 3 characters');
        hasError = true;
    } else if (title.length > 200) {
        showError('taskTitle', 'taskTitleError', 'Title must not exceed 200 characters');
        hasError = true;
    }

    // Validate description
    if (description.length < 5) {
        showError('taskDescription', 'taskDescriptionError', 'Description must be at least 5 characters');
        hasError = true;
    } else if (description.length > 1000) {
        showError('taskDescription', 'taskDescriptionError', 'Description must not exceed 1000 characters');
        hasError = true;
    }

    // Validate due date
    if (!dueDate) {
        showError('taskDueDate', 'taskDueDateError', 'Due date is required');
        hasError = true;
    } else {
        const selectedDate = new Date(dueDate);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (selectedDate < today) {
            showError('taskDueDate', 'taskDueDateError', 'Due date cannot be in the past');
            hasError = true;
        }
    }

    if (hasError) return;

    fetch('php/add_task.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ title, description, priority, dueDate })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            taskForm.reset();
            loadTasks();
        }
        showMessage(data.message, data.success ? 'success' : 'error', taskSection);
    });
});

// Load Tasks
function loadTasks(filter = 'all') {
    fetch(`php/get_tasks.php?filter=${filter}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                displayTasks(data.tasks);
            }
        });
}

// Display Tasks
function displayTasks(tasks) {
    taskList.innerHTML = '';
    if (tasks.length === 0) {
        taskList.innerHTML = '<p style="text-align: center; color: #888;">No tasks found</p>';
        return;
    }

    tasks.forEach(task => {
        const taskItem = document.createElement('div');
        taskItem.className = `task-item ${task.status} ${task.priority}`;
        taskItem.innerHTML = `
            <div class="task-title">${task.title}</div>
            <div class="task-description">${task.description}</div>
            <div class="task-meta">
                <span>Priority: ${task.priority}</span>
                <span>Due: ${task.due_date}</span>
                <span>Status: ${task.status}</span>
            </div>
            <div class="task-actions">
                ${task.status === 'pending' ? 
                    `<button class="complete-btn" onclick="completeTask(${task.id})">Complete</button>` : 
                    `<button class="complete-btn" onclick="uncompleteTask(${task.id})">Reopen</button>`
                }
                <button class="delete-btn" onclick="deleteTask(${task.id})">Delete</button>
            </div>
        `;
        taskList.appendChild(taskItem);
    });
}

// Complete Task
function completeTask(id) {
    fetch('php/update_task.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, status: 'completed' })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) loadTasks();
    });
}

// Uncomplete Task
function uncompleteTask(id) {
    fetch('php/update_task.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, status: 'pending' })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) loadTasks();
    });
}

// Delete Task
function deleteTask(id) {
    if (confirm('Are you sure you want to delete this task?')) {
        fetch('php/delete_task.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) loadTasks();
        });
    }
}

// Filter Tasks
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        loadTasks(btn.dataset.filter);
    });
});

// Helper Functions
function showTaskSection(username) {
    loginSection.classList.add('hidden');
    registerSection.classList.add('hidden');
    taskSection.classList.remove('hidden');
    userInfo.textContent = `Welcome, ${username}!`;
}

function showMessage(message, type, section) {
    const existingMsg = section.querySelector('.message');
    if (existingMsg) existingMsg.remove();

    const msgDiv = document.createElement('div');
    msgDiv.className = `message ${type}`;
    msgDiv.textContent = message;
    section.insertBefore(msgDiv, section.firstChild);

    setTimeout(() => msgDiv.remove(), 3000);
}
