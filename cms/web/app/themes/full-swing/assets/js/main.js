jQuery(document).ready(function ($) {
  const body = $('body')

  const cartSelect = () => {
    $('select.quantity').on('change', function (e) {
      const $this = $(this)
      const qty = $this.val()

      if ($this.hasClass('upsell')) {
        $('a[data-product_id="' + $this.data('product_id') + '"]').each(function () {
          $(this).data('quantity', qty)
        })
        return
      }

      $this.siblings('.data').find('input').val($this.val())
      $this.closest('form').find('[name="update_cart"]').trigger('click')
    })
  }

  // Cart Customizations
  if (body.hasClass('woocommerce-cart')) {
    cartSelect()

    $(document).on('ajaxComplete', function () {
      cartSelect()
    })
  }

  const handleAccessibilityClick = (e) => {
    // Select all shadow host elements of type 'access-widget-ui'
    const shadowHosts = document.querySelectorAll('access-widget-ui')

    // Find the shadow host that contains a button with part="acsb-trigger"
    const shadowHostWithButton = Array.from(shadowHosts).find(
      (shadowHost) => shadowHost.shadowRoot && shadowHost.shadowRoot.querySelector('button[part="acsb-trigger"]'),
    )

    if (shadowHostWithButton && shadowHostWithButton.shadowRoot) {
      const triggerButton = shadowHostWithButton.shadowRoot.querySelector('button[part="acsb-trigger"]')

      if (triggerButton) {
        const clickEvent = new MouseEvent('click', {
          bubbles: true,
          cancelable: true,
          view: window,
        })
        triggerButton.dispatchEvent(clickEvent)
      } else {
        console.log('Button with part="acsb-trigger" not found.')
      }
    } else {
      console.log('Shadow host with the specified button not found.')
    }
  }

  $('.accessibility_button').on('click', handleAccessibilityClick)
})
