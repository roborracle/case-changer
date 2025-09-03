# Auto-commit per Task

This system automatically commits and pushes changes when TaskMaster tasks are completed.

## How It Works

1. **Task Watcher** (`scripts/task_watcher.js`): Monitors the TaskMaster state file for task status changes
2. **Commit Script** (`scripts/commit_on_task_complete.sh`): Executes git commit and push when a task completes
3. **Automatic Flow**: When a task transitions to `done`, `completed`, or `success` status, the system:
   - Stages all changes (`git add -A`)
   - Creates a commit with message: `task(<id>): <title> [auto]`
   - Pushes to the current branch (with retry logic)
   - Optionally creates and pushes tags

## Environment Variables

Configure behavior via environment variables or `.env` file:

```bash
# Auto-push commits to remote (default: true)
AUTO_PUSH=true

# Create git tags for each completed task (default: false)  
AUTO_TAG=false

# Commit message prefix (default: "task")
COMMIT_PREFIX=task

# Log file location (default: logs/taskmaster-commit.log)
LOG_FILE=logs/taskmaster-commit.log
```

## Running Continuous Mode

Start the task watcher to monitor and auto-commit:

```bash
# Using npm
npm run task:run

# Or directly
node scripts/task_watcher.js
```

The watcher will:
- Monitor task status changes
- Auto-commit on task completion
- Automatically start the next pending task
- Log all actions to `logs/taskmaster-commit.log`

## Testing

Simulate a task completion without running actual work:

```bash
# Simulate task 1 completion
npm run task:simulate 1 done

# Or with specific task and status
node scripts/dev/simulate_task_complete.js <task-id> <status>
```

## Troubleshooting

### Push Failures

If push fails (e.g., network issues, authentication):
- The commit is still created locally
- The system retries 3 times with exponential backoff
- Check `logs/taskmaster-commit.log` for details
- Manually push with: `git push origin <branch>`

### Detached HEAD State

If you're in detached HEAD state:
1. Stop the watcher (Ctrl+C)
2. Checkout a branch: `git checkout -b <branch-name>`
3. Restart the watcher

### No Changes to Commit

The system safely handles cases where:
- No files have changed
- Only ignored files have changed
- Task completes with no code changes

### Log Rotation

Logs automatically rotate when they exceed 1MB:
- Current log: `logs/taskmaster-commit.log`
- Rotated logs: `logs/taskmaster-commit.log.1` through `.5`
- Keeps last 5 log files

## Manual Usage

To manually trigger a commit for a completed task:

```bash
bash scripts/commit_on_task_complete.sh "<task-id>" "<task-title>"
```

## Architecture

```
TaskMaster Task Completion
         ↓
    File Watcher Detects
         ↓
    Triggers Commit Script
         ↓
    Git Add + Commit + Push
         ↓
    Start Next Task
```

## Safety Features

- **No Commit on No Changes**: Skips commit if working tree is clean
- **Respects .gitignore**: Won't commit ignored files
- **Safe Concurrency**: Prevents multiple simultaneous commits
- **Graceful Shutdown**: Properly closes file watchers on exit
- **Retry Logic**: Handles temporary network failures
- **Logging**: Complete audit trail of all operations