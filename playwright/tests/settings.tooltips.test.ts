import { test, expect } from '@playwright/test';

test.describe( "Settings", ()=>{

  test('Enable and Save', async ({ page }) => {
   
    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-settings'); 

    await page.locator('#sh-cd-option-tool-tips-enabled').selectOption('no');
    await page.getByRole('button', { name: 'Save Changes' }).click();
    await expect(page.locator('#sh-cd-option-tool-tips-enabled')).toHaveValue('no');

    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
    page.hover('.yk-ss-button-add-full-editor');
    await expect(page.getByText('Use the full Visual or Code editor to add a new shortcode.')).toHaveCount(0);

    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-settings'); 
    await page.locator('#sh-cd-option-tool-tips-enabled').selectOption('yes');
    await page.getByRole('button', { name: 'Save Changes' }).click();
    await expect(page.locator('#sh-cd-option-tool-tips-enabled')).toHaveValue('yes');
    
    await page.goto('http://localhost/wp-admin/admin.php?page=sh-cd-shortcode-variables-your-shortcodes');
    page.hover('.yk-ss-button-add-full-editor');
    await expect(page.getByText('Use the full Visual or Code editor to add a new shortcode.')).toBeVisible();
  });
});
