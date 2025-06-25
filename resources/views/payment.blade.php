<!-- resources/views/payment.blade.php -->
<form action="/payment" method="POST" id="payment-form">
  @csrf
  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="{{ env('STRIPE_KEY') }}"
    data-amount="1000"
    data-name="Test App"
    data-description="Test Charge"
    data-currency="usd">
  </script>
</form>
