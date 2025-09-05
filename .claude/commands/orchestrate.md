# Orchestrate Concurrent Multi-Agent Workflow

Deploy multiple specialized agents concurrently to complete complex tasks efficiently for the Case Changer Pro project.

## Command: /orchestrate [task-description]

### Available Agents for Orchestration

**Development Team:**
- `backend-architect` - System design, API architecture
- `backend-developer` - Laravel implementation
- `frontend-developer` - Livewire/JavaScript components
- `devops-automator` - CI/CD and deployment

**Quality Team:**
- `test-writer-fixer` - Test creation and maintenance
- `ui-designer` - Visual design and accessibility
- `ux-researcher` - User behavior analysis
- `tool-evaluator` - Technology evaluation

**Task Management:**
- `task-orchestrator` - High-level coordination
- `task-executor` - Implementation tasks
- `task-checker` - Quality verification

## Orchestration Strategy

### Phase 1: Analysis & Architecture (Concurrent)
Deploy these agents in parallel to analyze and plan:

```yaml
CONCURRENT_PHASE_1:
  - backend-architect: "Analyze current architecture, identify improvement areas"
  - ui-designer: "Audit UI consistency, accessibility compliance" 
  - ux-researcher: "Evaluate user experience, identify pain points"
  - tool-evaluator: "Assess current tech stack, recommend optimizations"
```

### Phase 2: Implementation (Parallel Teams)

**Team Alpha - Core Features:**
```yaml
PARALLEL_EXECUTION:
  backend-developer:
    - Implement API endpoints
    - Optimize database queries
    - Add caching layer
  
  frontend-developer:
    - Build Livewire components
    - Optimize JavaScript bundles
    - Implement reactive features
```

**Team Beta - Quality & Testing:**
```yaml
PARALLEL_EXECUTION:
  test-writer-fixer:
    - Write unit tests for transformations
    - Create integration tests
    - Fix failing tests
  
  ui-designer:
    - Implement design improvements
    - Ensure WCAG compliance
    - Optimize responsive layouts
```

### Phase 3: Integration & Optimization (Synchronized)
```yaml
SYNCHRONIZED_PHASE:
  devops-automator: "Setup CI/CD pipeline, optimize deployment"
  task-checker: "Verify all implementations meet requirements"
  backend-architect: "Review and approve architecture changes"
```

## Case Changer Pro Specific Workflows

### Workflow 1: Add New Transformation Category
```yaml
agents:
  - ux-researcher: "Research user needs for new category"
  - backend-architect: "Design transformation architecture"
  - backend-developer: "Implement transformation logic"
  - frontend-developer: "Create UI components"
  - test-writer-fixer: "Write comprehensive tests"
  - ui-designer: "Polish UI and ensure consistency"
```

### Workflow 2: Performance Optimization Sprint
```yaml
concurrent_agents:
  team_1:
    - backend-architect: "Identify bottlenecks"
    - tool-evaluator: "Evaluate caching solutions"
  team_2:
    - backend-developer: "Optimize queries and algorithms"
    - frontend-developer: "Implement lazy loading"
  team_3:
    - devops-automator: "Setup CDN and optimize assets"
    - test-writer-fixer: "Create performance benchmarks"
```

### Workflow 3: UI/UX Overhaul
```yaml
phase_1_concurrent:
  - ux-researcher: "Conduct user research"
  - ui-designer: "Create new design system"
  - tool-evaluator: "Evaluate UI frameworks"

phase_2_parallel:
  - frontend-developer: "Implement new components"
  - ui-designer: "Create component variations"
  - test-writer-fixer: "Write visual regression tests"

phase_3_integration:
  - backend-developer: "Update API responses for new UI"
  - task-checker: "Verify all components work together"
```

## Execution Protocol

### 1. Task Analysis
```python
# Pseudo-code for task distribution
def analyze_request(task_description):
    complexity = assess_complexity(task_description)
    dependencies = identify_dependencies(task_description)
    
    if complexity > 7:
        return "multi_phase_orchestration"
    elif dependencies.count() > 3:
        return "sequential_with_parallel_subtasks"
    else:
        return "pure_parallel_execution"
```

### 2. Agent Deployment
Based on task analysis, deploy agents:

**For Feature Development:**
1. `task-orchestrator` - Break down requirements
2. Parallel deployment:
   - `backend-architect` + `backend-developer` (backend team)
   - `frontend-developer` + `ui-designer` (frontend team)
   - `test-writer-fixer` (quality team)
3. `task-checker` - Final validation

**For Bug Fixes:**
1. `test-writer-fixer` - Reproduce and isolate
2. Parallel deployment:
   - `backend-developer` OR `frontend-developer` (based on bug type)
   - `tool-evaluator` (if library-related)
3. `task-checker` - Verify fix

**For Optimization:**
1. Parallel analysis:
   - `backend-architect` - System analysis
   - `tool-evaluator` - Tool assessment
   - `ui-designer` - UI performance
2. Parallel implementation:
   - `backend-developer` - Backend optimizations
   - `frontend-developer` - Frontend optimizations
   - `devops-automator` - Infrastructure optimizations
3. `test-writer-fixer` - Performance validation

### 3. Synchronization Points

Agents synchronize at these checkpoints:
- After completing analysis phase
- Before integration of parallel work
- After each major milestone
- When conflicts detected

### 4. Communication Protocol

```yaml
message_passing:
  format: "AGENT_NAME: STATUS | BLOCKER | OUTPUT"
  
  examples:
    - "backend-developer: COMPLETE | NONE | API endpoints ready"
    - "frontend-developer: BLOCKED | Waiting for API spec | None"
    - "test-writer-fixer: IN_PROGRESS | NONE | 75% coverage"
```

## Example Orchestration Commands

### Example 1: Complete Feature Implementation
```
/orchestrate Implement advanced text statistics feature with character count, word frequency, and readability scores
```

**Expected Orchestration:**
1. `task-orchestrator` breaks down into subtasks
2. Concurrent Phase 1:
   - `backend-architect` designs data structure
   - `ux-researcher` analyzes user needs
   - `tool-evaluator` evaluates statistics libraries
3. Parallel Phase 2:
   - Team A: `backend-developer` implements algorithms
   - Team B: `frontend-developer` + `ui-designer` create UI
   - Team C: `test-writer-fixer` writes tests
4. Integration Phase:
   - `task-checker` validates implementation
   - `devops-automator` deploys to staging

### Example 2: Performance Optimization
```
/orchestrate Optimize the transformation engine to handle 10x larger texts
```

**Expected Orchestration:**
1. Parallel Analysis:
   - `backend-architect` profiles current bottlenecks
   - `tool-evaluator` researches optimization techniques
2. Concurrent Implementation:
   - `backend-developer` implements streaming processing
   - `frontend-developer` adds progress indicators
   - `devops-automator` scales infrastructure
3. Validation:
   - `test-writer-fixer` creates load tests
   - `task-checker` verifies improvements

### Example 3: Security Audit
```
/orchestrate Conduct security audit and implement improvements
```

**Expected Orchestration:**
1. `tool-evaluator` runs security scanners
2. Parallel fixes:
   - `backend-developer` patches vulnerabilities
   - `devops-automator` hardens infrastructure
3. `test-writer-fixer` creates security tests
4. `task-checker` validates all fixes

## Quality Gates

Each phase must pass quality gates:
- ✅ All agents report COMPLETE status
- ✅ No blocking dependencies remain
- ✅ Integration tests pass
- ✅ Code review approved
- ✅ Documentation updated

## Monitoring & Metrics

Track orchestration performance:
- Agent utilization rate
- Task completion time
- Parallel efficiency score
- Blocker frequency
- Quality gate pass rate

## Notes

- Agents work independently unless synchronization required
- Use Task Master for tracking progress (`task-master list`)
- Each agent maintains their own context
- Conflicts resolved by `task-orchestrator`
- Human intervention only for critical decisions

---

This orchestration command enables efficient parallel development while maintaining code quality and project coherence.