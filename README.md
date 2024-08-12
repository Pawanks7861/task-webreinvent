# To-Do List Application

This is a simple and interactive To-Do List application built with [Your Tech Stack]. The application allows users to manage their daily tasks efficiently, ensuring a smooth user experience with real-time updates and essential functionalities.

## Features

1. **Add Task Without Page Reload:**
   - When a user enters a new task and presses the enter button, the task instantly appears in the frontend without reloading or refreshing the page, ensuring a seamless user experience.

2. **Mark Task as Completed:**
   - Users can mark a task as completed by clicking on the checkbox next to the task. The task will disappear from the active tasks list and will be marked as completed.

3. **Show All Tasks:**
   - By clicking the "Show All Tasks" button, users can view all tasks, both completed and non-completed, allowing them to track their progress easily.

4. **Delete Task with Confirmation:**
   - Users can delete a task by clicking on the delete button. Before the task is deleted, a warning message ("Are you sure to delete this task?") will appear, ensuring that tasks are not accidentally removed.

5. **Prevent Duplicate Tasks:**
   - The application prevents the addition of duplicate tasks, ensuring that each task in the list is unique and reducing clutter.

## Usage

- **Add a Task:** Type your task in the input field and press enter. The task will be added to your list instantly.
- **Mark as Completed:** Click the checkbox next to the task to mark it as completed. The task will disappear from the active list.
- **Show All Tasks:** Click the "Show All Tasks" button to view all tasks, both completed and non-completed.
- **Delete a Task:** Click the delete button next to the task. Confirm the deletion in the warning dialog to remove the task permanently.



## Prerequisites

Before you begin, ensure you have met the following requirements:

- You have installed PHP >= 8.x.
- You have installed Composer.
- You have installed Laravel >= 9.x.
- You have installed a database like MySQL.

## Cloning the Repository

To clone the repository, run the following command:

```bash
composer install
```
Set up environment variables
```bash
cp .env.example .env
```
Generate the application key:
```bash
php artisan key:generate
```
Run database migrations:
```bash
php artisan migrate
```

## Running the Application
```bash
php artisan serve
```

