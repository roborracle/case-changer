#!/usr/bin/env bash

# Task completion auto-commit script
# Commits and optionally pushes changes when a task completes

set -euo pipefail

# Configuration from environment
AUTO_PUSH="${AUTO_PUSH:-true}"
AUTO_TAG="${AUTO_TAG:-false}"
COMMIT_PREFIX="${COMMIT_PREFIX:-task}"
LOG_FILE="${LOG_FILE:-logs/taskmaster-commit.log}"

# Arguments
TASK_ID="${1:-}"
TASK_TITLE="${2:-}"

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Ensure log directory exists
mkdir -p "$(dirname "$LOG_FILE")"

# Logging function
log_message() {
    local level="$1"
    shift
    local message="$*"
    local timestamp=$(date -u +"%Y-%m-%dT%H:%M:%SZ")
    echo "[$timestamp] [$level] $message" >> "$LOG_FILE"
    
    if [[ "$level" == "ERROR" ]]; then
        echo -e "${RED}[error]${NC} $message" >&2
    elif [[ "$level" == "INFO" ]]; then
        echo -e "${GREEN}[ok]${NC} $message"
    fi
}

# Rotate log if too large (>1MB)
rotate_log() {
    if [[ -f "$LOG_FILE" ]]; then
        local size=$(stat -f%z "$LOG_FILE" 2>/dev/null || stat -c%s "$LOG_FILE" 2>/dev/null || echo 0)
        if [[ $size -gt 1048576 ]]; then
            local i=5
            while [[ $i -gt 0 ]]; do
                [[ -f "${LOG_FILE}.$i" ]] && mv "${LOG_FILE}.$i" "${LOG_FILE}.$((i+1))"
                ((i--)) || true
            done
            mv "$LOG_FILE" "${LOG_FILE}.1"
            log_message "INFO" "Log rotated due to size"
        fi
    fi
}

# Check for required arguments
if [[ -z "$TASK_ID" ]] || [[ -z "$TASK_TITLE" ]]; then
    log_message "ERROR" "Missing required arguments: task_id and task_title"
    exit 1
fi

# Rotate log if needed
rotate_log

log_message "INFO" "Processing task completion: $TASK_ID - $TASK_TITLE"

# Get current branch
current_branch=$(git rev-parse --abbrev-ref HEAD)
log_message "INFO" "Current branch: $current_branch"

# Check if there are changes to commit
if git diff --quiet && git diff --cached --quiet; then
    log_message "INFO" "No changes to commit for task $TASK_ID"
    exit 0
fi

# Stage all changes
git add -A
log_message "INFO" "Staged all changes"

# Check if there are staged changes
if git diff --cached --quiet; then
    log_message "INFO" "No staged changes after git add -A"
    exit 0
fi

# Create commit message
commit_message="${COMMIT_PREFIX}($TASK_ID): $TASK_TITLE [auto]"

# Commit changes
if git commit -m "$commit_message" > /dev/null 2>&1; then
    commit_sha=$(git rev-parse --short HEAD)
    log_message "INFO" "${COMMIT_PREFIX}($TASK_ID) \"$TASK_TITLE\" -> $commit_sha on $current_branch"
    echo -e "${GREEN}[ok]${NC} ${COMMIT_PREFIX}($TASK_ID) \"$TASK_TITLE\" -> $commit_sha on $current_branch"
else
    log_message "ERROR" "Failed to commit changes for task $TASK_ID"
    exit 1
fi

# Optionally create tag
if [[ "$AUTO_TAG" == "true" ]]; then
    tag_name="${COMMIT_PREFIX}-${TASK_ID}"
    tag_message="$TASK_TITLE"
    if git tag -a "$tag_name" -m "$tag_message" > /dev/null 2>&1; then
        log_message "INFO" "Created tag: $tag_name"
    else
        log_message "ERROR" "Failed to create tag: $tag_name"
    fi
fi

# Optionally push changes
if [[ "$AUTO_PUSH" == "true" ]]; then
    # Push with retry logic
    max_attempts=3
    attempt=1
    backoff=2
    
    while [[ $attempt -le $max_attempts ]]; do
        log_message "INFO" "Push attempt $attempt of $max_attempts"
        
        if git push origin "$current_branch" > /dev/null 2>&1; then
            log_message "INFO" "Successfully pushed to origin/$current_branch"
            
            # Push tags if AUTO_TAG is enabled
            if [[ "$AUTO_TAG" == "true" ]]; then
                if git push origin --tags > /dev/null 2>&1; then
                    log_message "INFO" "Successfully pushed tags"
                else
                    log_message "ERROR" "Failed to push tags"
                fi
            fi
            break
        else
            log_message "ERROR" "Push attempt $attempt failed"
            if [[ $attempt -lt $max_attempts ]]; then
                sleep $backoff
                backoff=$((backoff * 2))
            else
                log_message "ERROR" "All push attempts failed for task $TASK_ID"
                echo -e "${YELLOW}[warning]${NC} Push failed but commit succeeded locally"
            fi
        fi
        ((attempt++))
    done
fi

log_message "INFO" "Task $TASK_ID processing complete"