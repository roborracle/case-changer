#!/usr/bin/env node

/**
 * Simulate task completion for testing the auto-commit pipeline
 */

const fs = require('fs');
const path = require('path');

const TASK_FILE = path.join(process.cwd(), '.taskmaster/tasks/tasks.json');

// Parse command line arguments
const args = process.argv.slice(2);
const taskId = args[0] || '1';
const newStatus = args[1] || 'done';

console.log(`\n=== Task Completion Simulator ===`);
console.log(`Task ID: ${taskId}`);
console.log(`New Status: ${newStatus}`);
console.log(`================================\n`);

// Read current tasks
if (!fs.existsSync(TASK_FILE)) {
    console.error(`Error: Task file not found: ${TASK_FILE}`);
    process.exit(1);
}

let tasksData;
try {
    const content = fs.readFileSync(TASK_FILE, 'utf8');
    tasksData = JSON.parse(content);
} catch (err) {
    console.error(`Error reading task file: ${err.message}`);
    process.exit(1);
}

// Find and update the task
let taskFound = false;
let taskTitle = '';

// Check in master tasks
if (tasksData.master && tasksData.master.tasks) {
    for (let task of tasksData.master.tasks) {
        if (String(task.id) === String(taskId)) {
            console.log(`Found task: "${task.title}"`);
            console.log(`Current status: ${task.status}`);
            task.status = newStatus;
            taskFound = true;
            taskTitle = task.title;
            break;
        }
        
        // Check subtasks
        if (task.subtasks) {
            for (let subtask of task.subtasks) {
                const subtaskId = `${task.id}.${subtask.id}`;
                if (String(subtaskId) === String(taskId)) {
                    console.log(`Found subtask: "${subtask.title}"`);
                    console.log(`Current status: ${subtask.status}`);
                    subtask.status = newStatus;
                    taskFound = true;
                    taskTitle = subtask.title;
                    break;
                }
            }
        }
        
        if (taskFound) break;
    }
}

if (!taskFound) {
    console.error(`Task ${taskId} not found`);
    process.exit(1);
}

// Write back the updated tasks
try {
    fs.writeFileSync(TASK_FILE, JSON.stringify(tasksData, null, 2));
    console.log(`✓ Task ${taskId} status updated to: ${newStatus}`);
} catch (err) {
    console.error(`Error writing task file: ${err.message}`);
    process.exit(1);
}

// Create a dummy change to commit
const testFile = path.join(process.cwd(), '.taskmaster', 'test-change.txt');
fs.writeFileSync(testFile, `Test change for task ${taskId} at ${new Date().toISOString()}\n`, { flag: 'a' });
console.log(`✓ Created test change file`);

console.log(`\nSimulation complete!`);
console.log(`The watcher should detect this change and trigger a commit.`);
console.log(`\nTo test the commit directly, run:`);
console.log(`  bash scripts/commit_on_task_complete.sh "${taskId}" "${taskTitle}"`);