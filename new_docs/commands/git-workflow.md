# Git Workflow Helper

Streamline git operations with best practices for the Case Changer Pro project.

## Command: /git-workflow [action]

Actions: feature, hotfix, release, sync, cleanup

## Workflow Actions

### Start New Feature
```bash
# Create feature branch from main
git checkout main
git pull origin main
git checkout -b feature/[feature-name]

# Link to task if using Task Master
task-master set-status --id=[task-id] --status=in-progress
```

### Create Clean Commit
```bash
# Stage changes selectively
git add -p

# Commit with conventional format
git commit -m "type(scope): description

- Detail 1
- Detail 2

Relates to: #issue-number or task-id"
```

#### Commit Types
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting, etc.)
- `refactor`: Code refactoring
- `perf`: Performance improvements
- `test`: Test additions or changes
- `chore`: Build process or auxiliary tool changes

### Create Pull Request
```bash
# Push branch
git push -u origin feature/[feature-name]

# Create PR with template
gh pr create \
  --title "feat: Add [feature]" \
  --body "## Summary
  
  [Brief description]
  
  ## Changes
  - Change 1
  - Change 2
  
  ## Testing
  - [ ] Unit tests pass
  - [ ] Integration tests pass
  - [ ] Manual testing completed
  
  ## Screenshots
  [If applicable]
  
  Closes #issue-number"
```

### Sync with Main
```bash
# Update your feature branch
git checkout main
git pull origin main
git checkout feature/[feature-name]
git rebase main

# Resolve conflicts if any
git status
# Fix conflicts in files
git add [resolved-files]
git rebase --continue
```

### Hotfix Process
```bash
# Create hotfix from main
git checkout main
git pull origin main
git checkout -b hotfix/[issue-description]

# Make fix and test
# ... make changes ...
npm test
php artisan test

# Commit and push
git commit -m "fix: [description]"
git push -u origin hotfix/[issue-description]

# Create urgent PR
gh pr create --title "HOTFIX: [issue]" --label "urgent"
```

### Release Process
```bash
# Create release branch
git checkout main
git pull origin main
git checkout -b release/v[version]

# Update version numbers
# Update package.json, composer.json, etc.

# Generate changelog
git log --pretty=format:"- %s" main..HEAD > CHANGELOG_DRAFT.md

# Create release commit
git commit -m "chore: prepare release v[version]"

# Tag release
git tag -a v[version] -m "Release version [version]"

# Push release
git push origin release/v[version]
git push origin v[version]
```

### Branch Cleanup
```bash
# Delete merged local branches
git branch --merged main | grep -v main | xargs -n 1 git branch -d

# Delete remote tracking branches
git remote prune origin

# List branches to review
git branch -a --sort=-committerdate | head -20
```

## Advanced Operations

### Interactive Rebase (Clean History)
```bash
# Squash last N commits
git rebase -i HEAD~N

# Change 'pick' to 'squash' for commits to combine
# Save and edit commit message
```

### Cherry Pick
```bash
# Apply specific commit to current branch
git cherry-pick [commit-hash]

# Apply multiple commits
git cherry-pick [hash1] [hash2] [hash3]
```

### Stash Management
```bash
# Save work in progress
git stash save "WIP: [description]"

# List stashes
git stash list

# Apply specific stash
git stash apply stash@{n}

# Pop latest stash
git stash pop
```

### Undo Operations
```bash
# Undo last commit (keep changes)
git reset --soft HEAD~1

# Undo last commit (discard changes)
git reset --hard HEAD~1

# Revert a pushed commit
git revert [commit-hash]
```

## Git Hooks Setup

### Pre-commit Hook
```bash
#!/bin/sh
# .git/hooks/pre-commit

# Run tests
php artisan test
if [ $? -ne 0 ]; then
    echo "Tests failed. Commit aborted."
    exit 1
fi

# Run linters
npm run lint
if [ $? -ne 0 ]; then
    echo "Linting failed. Commit aborted."
    exit 1
fi
```

### Commit Message Hook
```bash
#!/bin/sh
# .git/hooks/commit-msg

# Check commit message format
pattern="^(feat|fix|docs|style|refactor|perf|test|chore)(\(.+\))?: .+"
if ! grep -qE "$pattern" "$1"; then
    echo "Invalid commit message format!"
    echo "Format: type(scope): description"
    exit 1
fi
```

## Best Practices

### DO:
- ✅ Commit early and often
- ✅ Write clear commit messages
- ✅ Keep commits focused (one change per commit)
- ✅ Test before committing
- ✅ Pull before pushing
- ✅ Use feature branches
- ✅ Review your own PR first

### DON'T:
- ❌ Commit sensitive data (.env, keys)
- ❌ Force push to main
- ❌ Commit generated files
- ❌ Mix features in one commit
- ❌ Leave console.log/dd() in commits
- ❌ Commit broken code
- ❌ Ignore conflicts

## Quick Status Check
```bash
# Complete status overview
echo "=== Git Status ==="
git status -sb
echo -e "\n=== Recent Commits ==="
git log --oneline -5
echo -e "\n=== Current Branch ==="
git branch --show-current
echo -e "\n=== Remote Status ==="
git remote -v
echo -e "\n=== Stashes ==="
git stash list
```