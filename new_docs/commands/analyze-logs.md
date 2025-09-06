Analyze all error logs, console outputs, and provide a comprehensive report with cleanup options.

Steps:

1. **Collect Laravel Logs**
   - Read `storage/logs/laravel.log`
   - Parse recent errors (last 24 hours)
   - Group errors by type and frequency
   - Identify critical vs warning vs info messages

2. **Check PHP Error Logs**
   - Check system PHP error log
   - Look for fatal errors, warnings, notices
   - Identify deprecated function usage

3. **Analyze Browser Console Errors**
   - Check for JavaScript errors
   - Look for CSP violations
   - Network/resource loading failures
   - Livewire component errors

4. **Check Build/Compilation Logs**
   - npm/node warnings and errors
   - Vite build issues
   - Asset compilation problems
   - Missing dependencies

5. **Database Query Logs** (if enabled)
   - Slow queries
   - Failed queries
   - N+1 query problems

6. **Security Audit Logs**
   - Failed authentication attempts
   - CSRF token mismatches
   - Rate limiting hits
   - Suspicious activity patterns

7. **Performance Logs**
   - Slow response times
   - Memory usage spikes
   - CPU intensive operations

8. **Generate Report**
   - Summary of all error types
   - Count of each error
   - Severity assessment
   - Recommended fixes

9. **Cleanup Options**
   - Archive old logs
   - Clear resolved errors
   - Reset log files
   - Keep only recent entries

10. **Action Items**
    - List critical errors that need immediate attention
    - Suggest fixes for common issues
    - Provide commands to resolve known problems

This helps maintain a clean, error-free application by systematically addressing all logged issues.