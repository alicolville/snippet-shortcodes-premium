import { test, expect } from '@playwright/test';

test.describe.configure({ mode: 'serial' });

test('Own: Doesn\'t already exist', async ({ page }) => {
  await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
  await expect(page.locator('.yk-ss-row-playwright-full-editor-add')).toHaveCount(0); 
});

test('Own: Full Editor: Add shortcode', async ({ page }) => {

  await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
 
  await page.getByRole('cell', { name: 'Quick Add Add via Editor' }).getByRole('link').click();
  await page.getByPlaceholder('Slug').click();
  await page.getByPlaceholder('Slug').fill('Playwright Full-edItor-add');
  await page.frameLocator('iframe[title="Rich Text Area\\. Press Alt-Shift-H for help\\."]').locator('html').click();
  await page.frameLocator('iframe[title="Rich Text Area\\. Press Alt-Shift-H for help\\."]').locator('#tinymce').fill('Add something here. Playwright Full Editor Add');
  await page.getByRole('button', { name: 'Save Shortcode' }).nth(1).click();
  await expect(page.locator('.yk-ss-row-playwright-full-editor-add .slug-link')).toContainText('[sv slug="playwright-full-editor-add"]');
  await expect(page.locator('.yk-ss-row-playwright-full-editor-add .inline-text-shortcode')).toContainText('Add something here. Playwright Full Editor Add');

  await page.goto('http://localhost/sv-test/');

  await expect(page.locator('.test-1')).toContainText('Add something here. Playwright Full Editor Add');
});

test('Own: Disable and Enable', async ({ page }) => {

  await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
  await page.locator('.yk-ss-row-playwright-full-editor-add .toggle-disable').click();

  await page.goto('http://localhost/sv-test/');
  await expect(page.locator('.test-1')).toContainText('');

  await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
  await page.locator('.yk-ss-row-playwright-full-editor-add .toggle-disable').click();

  await page.goto('http://localhost/sv-test/');
  await expect(page.locator('.test-1')).toContainText('Add something here. Playwright Full Editor Add');
});


test('Own: Delete shortcode', async ({ page }) => {

  await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
 
  page.on('dialog', dialog => dialog.accept());

  await page.locator('.yk-ss-row-playwright-full-editor-add .delete-shortcode').click();
  
  await expect(page.locator('.yk-ss-row-playwright-full-editor-add')).toHaveCount(0); 

  await page.goto('http://localhost/sv-test/');

  await expect(page.locator('.test-1')).toContainText('');

});
