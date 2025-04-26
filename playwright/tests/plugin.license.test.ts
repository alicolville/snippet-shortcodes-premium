import { test, expect } from '@playwright/test';

test('Plugin: License enabled', async ({ page }) => {
  
  await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-upgrade');
  await expect(page.locator('.yk-ss-existing-license')).toBeVisible();

});

test('Plugin: Remove and add licence', async ({ page }) => {
  
  await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-upgrade');
  
  await page.getByRole('link', { name: 'Remove License' }).click();
  
  await expect(page.locator('.yk-ss-license-expiry-date')).toContainText('No active license');
  
  await expect(page.locator('.yk-ss-notice-missing-core-plugin')).toHaveCount(0);

  await page.getByRole('textbox').fill('eyJ0eXBlIjoic3YtcHJlbWl1bSIsImV4cGlyeS1kYXlzIjoxNjAwMCwic2l0ZS1oYXNoIjoiYzk3ZGY1IiwiZXhwaXJ5LWRhdGUiOiIyMDY5LTAyLTE0IiwiaGFzaCI6IjM3M2Y4NGVkYzFiNzIwOGYzNDZhZDc4OTE5ZDUzMjJmIn0');
  
  await page.getByRole('button', { name: 'Apply License' }).click();
  
  await expect(page.locator('.yk-ss-existing-license')).toBeVisible();

});

//yk-ss-existing-license

// test('Admin Notices: Prompt to install core plugin if not activated', async ({ page }) => {
  
//   await page.goto('http://localhost/wp-admin/plugins.php');

//   await page.getByLabel('Deactivate Snippet Shortcodes', { exact: true } ).click();
 
//   await expect(page.locator('.yk-ss-notice-missing-core-plugin')).toBeVisible();

//   await page.getByLabel('Activate Snippet Shortcodes', { exact: true }).click();

//   await expect(page.locator('.yk-ss-notice-missing-core-plugin')).toHaveCount(0);
//});
