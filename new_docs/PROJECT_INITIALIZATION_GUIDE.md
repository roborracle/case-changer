# Complete Project Initialization Guide for Case Changer v3.0

## 🚀 Full Setup Instructions for New Project

This guide provides step-by-step instructions to initialize Case Changer v3.0 from scratch using the documentation in this folder.

## Prerequisites

### Required Software
- Node.js 18+ and npm
- Git
- Claude Code (Anthropic's CLI)
- VS Code or preferred editor
- Railway CLI (optional for deployment)

## Step 1: Claude Code Setup

### Install Claude Code
```bash
# If not already installed
npm install -g @anthropic/claude-code
```

### Initialize Claude Code in New Project Directory
```bash
# Create new project directory
mkdir case-changer-v3
cd case-changer-v3

# Initialize Claude Code
claude init

# This creates .claude/ directory structure
```

## Step 2: Task Master Setup

### Install Task Master
```bash
# Install globally
npm install -g task-master-ai

# Or install locally
npm install --save-dev task-master-ai
```

### Initialize Task Master
```bash
# Initialize Task Master in project
task-master init

# This creates .taskmaster/ directory with:
# - config.json
# - tasks/
# - docs/
# - templates/
```

### Configure Task Master Models
```bash
# Set up AI models (interactive)
task-master models --setup

# Or set directly
task-master models --set-main claude-3-5-sonnet-20241022
task-master models --set-research perplexity-llama-3.1-sonar-large-128k-online
task-master models --set-fallback gpt-4o-mini
```

### Set API Keys
Create `.env` file:
```env
# Required API Keys (at least one)
ANTHROPIC_API_KEY=your_key_here
PERPLEXITY_API_KEY=your_key_here  # For research features
OPENAI_API_KEY=your_key_here
```

## Step 3: Copy Documentation Structure

### Copy Essential Files
```bash
# Copy agents and commands from new_docs
cp -r path/to/new_docs/agents .claude/
cp -r path/to/new_docs/commands .claude/

# Copy CLAUDE.md for Task Master integration
cp path/to/new_docs/CLAUDE.md .claude/

# Copy project context
cp path/to/new_docs/project-context.md .claude/
```

### Create SCARLETT Rules Directory
```bash
# Create rules directory
mkdir -p .claude/rules

# Create rule files (content from SCARLETT_INTEGRATION.md)
touch .claude/rules/01-problem-solving.md
touch .claude/rules/02-no-quick-fixes.md
touch .claude/rules/03-brainstorming.md
touch .claude/rules/04-deep-research.md
touch .claude/rules/05-coding-standards.md
touch .claude/rules/06-testing-validation.md
touch .claude/rules/07-documentation.md
touch .claude/rules/08-cache-protocols.md
touch .claude/rules/09-security.md
touch .claude/rules/10-quality-gates.md
```

## Step 4: Configure Claude Settings

### Create .claude/settings.json
```json
{
  "allowedTools": [
    "Edit",
    "Bash(task-master *)",
    "Bash(git commit:*)",
    "Bash(git add:*)",
    "Bash(npm run *)",
    "Read",
    "Write",
    "MultiEdit",
    "Grep",
    "Glob",
    "mcp__task_master_ai__*"
  ],
  "customInstructions": "NEVER use Alpine.js. NEVER use unsafe-eval. Always maintain strict CSP compliance.",
  "projectType": "case-changer-v3"
}
```

### Create .claude/settings.local.json (optional)
```json
{
  "developerMode": true,
  "verboseLogging": true,
  "autoSave": true
}
```

## Step 5: MCP Server Configuration

### Create .mcp.json
```json
{
  "mcpServers": {
    "task-master-ai": {
      "command": "npx",
      "args": ["-y", "--package=task-master-ai", "task-master-ai"],
      "env": {
        "ANTHROPIC_API_KEY": "${ANTHROPIC_API_KEY}",
        "PERPLEXITY_API_KEY": "${PERPLEXITY_API_KEY}",
        "OPENAI_API_KEY": "${OPENAI_API_KEY}"
      }
    }
  }
}
```

## Step 6: Initialize Tech Stack

### Option A: React with Next.js (Recommended)
```bash
# Create Next.js app with TypeScript and Tailwind
npx create-next-app@latest . --typescript --tailwind --app --no-src-dir

# Install additional dependencies
npm install --save-dev @types/node

# Create strict CSP configuration
cp path/to/new_docs/REACT_IMPLEMENTATION_GUIDE.md docs/
```

### Option B: Laravel + Inertia + React
```bash
# Create Laravel project
composer create-project laravel/laravel .

# Install Inertia
composer require inertiajs/inertia-laravel
npm install @inertiajs/react react react-dom

# Configure for strict CSP
php artisan make:middleware GenerateCspNonce
```

## Step 7: Create PRD and Parse Tasks

### Create PRD Document
```bash
# Copy PRD template
cp path/to/new_docs/NEW_PROJECT_PRD.md .taskmaster/docs/prd.txt

# Edit PRD with project specifics
```

### Parse PRD into Tasks
```bash
# Parse PRD to generate tasks
task-master parse-prd .taskmaster/docs/prd.txt

# Analyze complexity
task-master analyze-complexity --research

# Expand all tasks
task-master expand --all --research
```

## Step 8: Set Up Git and Version Control

### Initialize Git
```bash
git init
git add .
git commit -m "Initial commit: Case Changer v3.0 setup"
```

### Create .gitignore
```gitignore
# Dependencies
node_modules/
vendor/

# Environment
.env
.env.local

# Build outputs
.next/
dist/
build/

# IDE
.vscode/
.idea/

# Task Master
.taskmaster/state.json
.taskmaster/reports/

# Logs
*.log
```

## Step 9: Configure Pre-commit Hooks

### Install Husky
```bash
npm install --save-dev husky
npx husky init
```

### Create CSP Validation Hook
```bash
# .husky/pre-commit
#!/bin/sh

# Check for Alpine.js
if grep -r "Alpine\|x-data\|x-show" --include="*.js" --include="*.jsx" --include="*.ts" --include="*.tsx" .; then
  echo "❌ FATAL: Alpine.js detected! Alpine.js is FORBIDDEN."
  exit 1
fi

# Check for unsafe-eval
if grep -r "unsafe-eval" .; then
  echo "❌ FATAL: unsafe-eval detected! This is FORBIDDEN."
  exit 1
fi

echo "✅ CSP compliance check passed"
```

## Step 10: Railway Deployment Setup

### Create railway.toml
```toml
[build]
builder = "NIXPACKS"
buildCommand = "npm ci && npm run build"

[deploy]
startCommand = "npm start"
healthcheckPath = "/api/health"
restartPolicyType = "ON_FAILURE"

[env]
NODE_ENV = "production"
```

### Deploy to Railway
```bash
# Install Railway CLI
npm install -g @railway/cli

# Login to Railway
railway login

# Initialize project
railway init

# Deploy
railway up
```

## Step 11: Create Development Scripts

### package.json scripts
```json
{
  "scripts": {
    "dev": "next dev",
    "build": "next build",
    "start": "next start",
    "test": "jest",
    "test:csp": "node scripts/test-csp.js",
    "validate": "npm run test:csp && npm run test",
    "task:next": "task-master next",
    "task:list": "task-master list",
    "task:done": "task-master set-status --id=$1 --status=done"
  }
}
```

## Step 12: Final Validation Checklist

### Run Pre-flight Checks
```bash
# 1. Verify no Alpine.js
grep -r "Alpine" . && echo "FAIL" || echo "PASS"

# 2. Verify no unsafe-eval
grep -r "unsafe-eval" . && echo "FAIL" || echo "PASS"

# 3. Test CSP headers
npm run dev
# Open browser console - should show ZERO violations

# 4. Check Task Master
task-master list

# 5. Test Claude Code
claude --version
```

## Step 13: Start Development

### Launch Claude Code
```bash
# Start Claude Code in project directory
claude

# Or with specific task
claude -p "task-master next"
```

### Development Workflow
1. Check next task: `task-master next`
2. Implement feature with CSP compliance
3. Test for violations: `npm run test:csp`
4. Mark complete: `task-master set-status --id=X --status=done`
5. Repeat

## Critical Reminders

### ❌ NEVER USE
- Alpine.js (requires unsafe-eval)
- Any eval-based framework
- Runtime template compilation
- Inline event handlers
- document.write()

### ✅ ALWAYS USE
- Strict CSP from day one
- Pre-compiled templates
- React/Vue 3/Svelte (compiled)
- Server-side validation
- Nonce-based scripts

## Troubleshooting

### If CSP Violations Occur
1. STOP immediately
2. Check browser console
3. Identify source
4. Remove offending code
5. Re-test

### If Alpine.js Is Detected
1. Project is contaminated
2. Full audit required
3. Remove ALL Alpine.js
4. Restart from clean state

### Task Master Issues
```bash
# Reset Task Master
rm -rf .taskmaster/state.json
task-master init

# Regenerate tasks
task-master generate
```

## Success Criteria

v3.0 is ready when:
- [ ] Zero CSP violations
- [ ] No Alpine.js anywhere
- [ ] Task Master configured
- [ ] Claude Code working
- [ ] Pre-commit hooks active
- [ ] Railway deployment ready
- [ ] All documentation in place

## Resources

### Documentation to Read First
1. `CATASTROPHIC_FAILURE_ANALYSIS.md` - Understand what failed
2. `PRE_FLIGHT_CHECKLIST.md` - Validate setup
3. `SECURITY_IMPLEMENTATION_GUIDE.md` - Security requirements
4. `SCARLETT_INTEGRATION.md` - Quality gates
5. `REACT_IMPLEMENTATION_GUIDE.md` - If using React

### Support
- Task Master: `task-master help`
- Claude Code: `/help` in Claude
- Documentation: See `V2_PROJECT_MASTER_INDEX.md`

---

**Remember: v1.0 died from Alpine.js. v3.0 succeeds with strict CSP compliance.**

**NO ALPINE.JS. NO UNSAFE-EVAL. EVER.**