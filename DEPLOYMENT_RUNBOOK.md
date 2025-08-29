# Deployment Runbook: Case Changer Pro

## 1. Pre-Deployment Checklist

- [ ] All development tasks are merged into the `main` branch.
- [ ] All tests are passing in the CI/CD pipeline.
- [ ] The production database has been backed up.
- [ ] The `.env.production` file has been created and populated with all necessary environment variables.
- [ ] The `RAILWAY_ENV_VARS.md` document has been reviewed and is up-to-date.

## 2. Deployment Commands Sequence

1.  **Push to production branch:**
    ```bash
    git checkout production
    git merge main
    git push origin production
    ```
2.  **Monitor deployment on Railway:**
    - Open the Railway project dashboard.
    - Monitor the deployment logs for any errors.

## 3. Post-Deployment Verification

- [ ] The application is live at the production URL.
- [ ] The health check endpoint (`/health`) returns a `200 OK` response.
- [ ] The application version number is correct.
- [ ] All 172 transformation tools are functional.
- [ ] There are no console errors in the browser.
- [ ] Lighthouse scores are >95.
- [ ] Security headers are active.
- [ ] SSL is working correctly.
- [ ] Schema.org markup validates.
- [ ] Brand links are working.

## 4. Rollback Procedure

1.  **Revert the last deployment on Railway:**
    - Open the Railway project dashboard.
    - Navigate to the "Deployments" tab.
    - Select the previous successful deployment and click "Redeploy".
2.  **Revert the merge to the `production` branch:**
    ```bash
    git checkout production
    git revert HEAD --no-edit
    git push origin production
    ```

## 5. Emergency Contacts

- **Lead Developer:** Robert David Orr (@roborracle)
- **Support Email:** support@robertdavidorr.com

## 6. Monitoring URLs

- **Railway Dashboard:** [https://railway.app/](https://railway.app/)
- **Sentry Dashboard:** [https://sentry.io/](https://sentry.io/)
- **Health Check Endpoint:** `https://case-changer-pro.up.railway.app/health`
