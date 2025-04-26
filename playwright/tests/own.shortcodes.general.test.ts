import { test, expect } from '@playwright/test';

test.describe.configure({ mode: 'serial' });

test.describe( "Own Shortcode", ()=>{

  test('Doesn\'t already exist', async ({ page }) => {
    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
    await expect(page.locator('.yk-ss-row-playwright-full-editor-add')).toHaveCount(0); 
    await expect(page.locator('.yk-ss-row-playwright-quick-add')).toHaveCount(0); 
  });
  
  test( 'Add shortcode via full editor', async ({ page }) => {
  
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
  
  test( 'Quick button: Disable and Enable', async ({ page }) => {
  
    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
    await page.locator('.yk-ss-row-playwright-full-editor-add .toggle-disable').click();
  
    await page.goto('http://localhost/sv-test/');
    await expect(page.locator('.test-1')).toContainText('');
  
    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
    await page.locator('.yk-ss-row-playwright-full-editor-add .toggle-disable').click();
  
    await page.goto('http://localhost/sv-test/');
    await expect(page.locator('.test-1')).toContainText('Add something here. Playwright Full Editor Add');
  });
  
  test('Inline edit', async ({ page }) => {
  
    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
    
    await expect(page.locator('.yk-ss-row-playwright-full-editor-add .inline-text-shortcode')).toContainText('Add something here. Playwright Full Editor Add');
  
    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
    await page.locator('.yk-ss-row-playwright-full-editor-add .inline-text-shortcode').click();
    await page.locator('.yk-ss-row-playwright-full-editor-add .inline-text-shortcode').fill('Changed this via the inline editor!');
    await page.locator('.yk-ss-row-playwright-full-editor-add .sh-cd-inline-save-button').click();
   
    await page.reload();

    await expect(page.locator('.yk-ss-row-playwright-full-editor-add .inline-text-shortcode')).toContainText('Changed this via the inline editor!');
    
    await page.goto('http://localhost/sv-test/');
    await expect(page.locator('.test-1')).toContainText('Changed this via the inline editor!');
  });
  
  test( 'Inline add', async ({ page }) => {
  
    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
   
    await page.locator('.button-add-inline').click();

    await page.getByPlaceholder('Slug').click();
    await page.getByPlaceholder('Slug').fill('playwright Quick Add');
  
    await page.locator('#sh-cd-add-inline-text').click();
    await page.locator('#sh-cd-add-inline-text').fill('Added this via the inline editor!');
    
    await page.getByText('Add', { exact: true }).click();
    
    await page.reload();

    await expect(page.locator('.yk-ss-row-playwright-quick-add .slug-link')).toContainText('[sv slug="playwright-quick-add"]');

    await page.goto('http://localhost/sv-test/');
    await expect(page.locator('.test-2')).toContainText('Added this via the inline editor!');
  });

  test( 'Delete shortcodes', async ({ page }) => {
  
    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
   
    page.on('dialog', dialog => dialog.accept());
  
    await page.locator('.yk-ss-row-playwright-full-editor-add .delete-shortcode').click();
    await page.locator('.yk-ss-row-playwright-quick-add .delete-shortcode').click();
    
    await page.reload();
    
    await expect(page.locator('.yk-ss-row-playwright-full-editor-add')).toHaveCount(0);
    await expect(page.locator('.yk-ss-row-playwright-quick-add')).toHaveCount(0); 
  
    await page.goto('http://localhost/sv-test/');
  
    await expect(page.locator('.test-1')).toContainText('');
    await expect(page.locator('.test-2')).toContainText('');
  });

});
