<h2>Hello {{ $user->first_name }}!</h2>
<p>You have successfully created a new product:</p>

<ul>
    <li><strong>Name:</strong> {{ $product->name }}</li>
    <li><strong>Description:</strong> {{ $product->description }}</li>
    <li><strong>Price:</strong> ${{ $product->price }}</li>
    <li><strong>Status:</strong> {{ $product->status }}</li>
</ul>

<p>Thank you!</p>
