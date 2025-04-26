import { test, expect } from '@playwright/test';

test.describe.configure({ mode: 'serial' });

test.describe( "License", ()=>{
  
  test('Add and ensure valid license', async ({ page }) => {
    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-upgrade');
    await page.locator('.license-key').fill('eyJ0eXBlIjoic3YtcHJlbWl1bSIsImV4cGlyeS1kYXlzIjoxNjAwMCwic2l0ZS1oYXNoIjoiYzk3ZGY1IiwiZXhwaXJ5LWRhdGUiOiIyMDY5LTAyLTE0IiwiaGFzaCI6IjM3M2Y4NGVkYzFiNzIwOGYzNDZhZDc4OTE5ZDUzMjJmIn0');
    await page.getByRole('button', { name: 'Apply License' }).click();
    await expect(page.locator('.yk-ss-existing-license')).toBeVisible();
  });

  test('Remove license', async ({ page }) => {
  
    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-upgrade');
    
    await page.getByRole('link', { name: 'Remove License' }).click();
    
    await expect(page.locator('.yk-ss-license-expiry-date')).toContainText('No active license');
    
    await expect(page.locator('.yk-ss-notice-missing-core-plugin')).toHaveCount(0);
  
  });

  test('Check UI elements are disabled', async ({ page }) => {
  
    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
    await expect(page.locator('.yk-ss-shortcode-stats')).toContainText('Go unlimited');
  
    await page.getByText('Quick Add').click();
    await page.getByPlaceholder('Slug').click();
    await page.getByPlaceholder('Slug').fill('test-slug');
    await page.locator('#sh-cd-add-inline-text').click();
    await page.locator('#sh-cd-add-inline-text').fill('Test Content');
    await page.getByText('Add', { exact: true }).click();
    await expect(page.locator('.sh-cd-upgrade-button')).toBeVisible();
  });

  test('Add license', async ({ page }) => {
  
    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-upgrade');

    await page.locator('.license-key').fill('eyJ0eXBlIjoic3YtcHJlbWl1bSIsImV4cGlyeS1kYXlzIjoxNjAwMCwic2l0ZS1oYXNoIjoiYzk3ZGY1IiwiZXhwaXJ5LWRhdGUiOiIyMDY5LTAyLTE0IiwiaGFzaCI6IjM3M2Y4NGVkYzFiNzIwOGYzNDZhZDc4OTE5ZDUzMjJmIn0');
    
    await page.getByRole('button', { name: 'Apply License' }).click();
    
    await expect(page.locator('.yk-ss-existing-license')).toBeVisible();
  
  });
});