<?php

namespace Tests\Unit\Blade\Modules\Proveedores;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Tests\TestCase;
// If your x-form-select or x-form-auditoria components cause issues during rendering
// (e.g., by trying to access the database), you might need to mock them.
// Example:
// use Illuminate\Support\Facades\Blade;
// use App\View\Components\FormSelect; // Ensure this is the correct namespace for your component
// use App\View\Components\FormAuditoria; // Ensure this is the correct namespace

class ContactosBladeTest extends TestCase
{
    use InteractsWithViews;

    /**
     * Sets up the testing environment.
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // If your components (like x-form-select) require database access or specific setup,
        // you might need to mock them here to ensure your view tests run in isolation
        // and don't fail due to external dependencies.
        //
        // Example of mocking a component:
        // Blade::component('form-select', \Tests\Mocks\View\Components\MockFormSelect::class);
        // Blade::component('form-auditoria', \Tests\Mocks\View\Components\MockFormAuditoria::class);
        //
        // For this example, we'll assume the view can render without extensive mocking.
        // If rendering fails, component mocking is the first thing to investigate.
    }

    /**
     * Test that the contactos form and its associated save button event are structured correctly
     * when the 'saveEvent' attribute is active (i.e., uncommented).
     *
     * This test assumes the 'saveEvent' attribute on the x-buttons component
     * is UNCOMMENTED and contains the JavaScript logic for form submission and UI update.
     * If 'saveEvent' is commented out in your actual Blade file, parts of this test related
     * to the saveEvent content will naturally fail, which is expected.
     */
    public function test_contactos_form_and_save_event_are_correctly_structured_when_active(): void
    {
        $view = $this->view('modules.Proveedores.contactos');

        // 1. Assert the form for proveedor contactos exists
        $view->assertSee('id="proveedorescontactosForm"', false);
        $view->assertSee('method="POST"', false);

        // 2. Assert the x-buttons component is present and configured for this form
        $view->assertSee('<x-buttons', false); // Check for the component tag
        $view->assertSee('formId="proveedorescontactosForm"', false);

        // 3. Assert the 'saveEvent' attribute (if uncommented) contains the correct JavaScript logic.
        //    We check for key parts of the JavaScript string.
        //    The {{-- ... --}} Blade comment inside the JS string would be removed by Blade before
        //    the string is passed as a prop.
        
        // Key JavaScript lines expected in the saveEvent attribute's value:
        $jsLine1 = "const form = document.getElementById('proveedorescontactosForm');";
        // The original JS has a comment: "form.dispatchEvent(new Event('submit'));  // sigue usando BaseModule.js"
        // We'll check for the core part.
        $jsLine2 = "form.dispatchEvent(new Event('submit'));";
        $jsLine3 = "mostrarFormContacto = false;";

        // These assertions check if these specific JavaScript strings appear in the rendered output.
        // This test assumes 'saveEvent' is uncommented in the Blade file.
        $view->assertSee($jsLine1, false);
        $view->assertSee($jsLine2, false);
        $view->assertSee($jsLine3, false);
        
        // Also check for the 'cancelEvent' as it's defined in the file
        $view->assertSee('cancelEvent="', false);
        // The cancelEvent also includes "mostrarFormContacto = false;"
        // We can check for its specific structure if needed, e.g., ensuring it's part of cancelEvent.
        // For now, the previous assertSee for $jsLine3 covers its presence.
        $view->assertSee("mostrarFormContacto = false;", false); 
    }

    /**
     * Test that the 'saveEvent' attribute for 'proveedorescontactosForm' is currently commented out.
     * This test reflects the current state of the provided 'contactos.blade.php' file
     * where the 'saveEvent' attribute is within Blade comments.
     */
    public function test_save_event_for_contactos_form_is_commented_out(): void
    {
        $view = $this->view('modules.Proveedores.contactos');

        // Assert that the saveEvent attribute is within Blade comments.
        // We look for the Blade comment tags surrounding the 'saveEvent' attribute definition.
        $view->assertSeeInOrder([
            '{{-- saveEvent="', // Start of the commented attribute
            "const form = document.getElementById('proveedorescontactosForm');", // A key part of the commented JS
            "form.dispatchEvent(new Event('submit'));", // Another key part
            "mostrarFormContacto = false;", // And another
            '" --}}' // End of the Blade comment for the attribute
        ], false); // `false` means do not escape HTML entities in the search string.
    }
}