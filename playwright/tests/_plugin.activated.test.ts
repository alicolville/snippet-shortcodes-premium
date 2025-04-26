import { test, expect } from '@playwright/test';

test('Plugins: activated', async ({ page }) => {
  
  await page.goto('http://localhost/wp-admin/plugins.php');

  await expect(page.getByLabel('Deactivate Snippet Shortcodes', { exact: true })).toContainText('Deactivate');
  await expect(page.getByLabel('Deactivate Snippet Shortcodes - Premium features')).toContainText('Deactivate');
  
});

test('Admin Notices: Prompt to install core plugin if not activated', async ({ page }) => {
  
  await page.goto('http://localhost/wp-admin/plugins.php');

  await page.getByLabel('Deactivate Snippet Shortcodes', { exact: true } ).click();
 
  await expect(page.locator('.yk-ss-notice-missing-core-plugin')).toBeVisible();

  await page.getByLabel('Activate Snippet Shortcodes', { exact: true }).click();

  await expect(page.locator('.yk-ss-notice-missing-core-plugin')).toHaveCount(0);
});
