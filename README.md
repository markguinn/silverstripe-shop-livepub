Silverstripe Shop-LivePub Integration
=====================================

SS-Shop <https://github.com/burnbright/silverstripe-shop> provides a great e-commerce platform
for Silverstripe CMS. LivePub <https://github.com/markguinn/silverstripe-livepub> combined with
Static Publishing <https://github.com/silverstripe-labs/silverstripe-staticpublishqueue> provides
static page caching with live PHP "holes" for things like cooke or session-specific code or
CSRF tokens.

This module provides some common use cases for an e-commerce site under livepub+staticpublisqueue:

Side Cart
---------
Enough information about the cart is kept in the session to display SideCart template. Template
is located at 'shop_livepub/templates/php/SideCart.php' or you can add one in the templates/php
subfolder of your theme (see livepub docs). Then replace:

```
<% include SideCart %>
```
with:
```
$IncludePHP('SideCart')
```

If the session cart gets out of whack, add `?debugsessioncart=1` to the url to see what's in
it or `?rebuildsessioncart=1` or `?flush=1` to rebuild it from the cart.


Logged In User
--------------
Add `class="$LoggedInClass"` to body, html, or any container element in your template and
then use the `.show-for-members` and `.hide-for-members` css classes if there are elements
of the page that only apply to logged in users.

There are also two php templates:

```
$IncludePHP('MemberLinks')
$IncludePHP('LoggedInAs')
```

The first will give you "My Account" and "Sign Out" links if you're logged in and a "Sign In"
link if not. The second will give the logged in user's name if one is present.

In both cases, the page can safely be statically cached and the user will still see the correct
elements based on session state.


Add to / Remove from Cart
-------------------------
Similar to user state, within the scope of a product you can use `class="$CartStateClass"` on
a container element and then add `.show-for-product-in-cart` and `.hide-for-product-in-cart`
classes to buttons or form fields that depend on the state of the cart. For example:

```
<div class="$CartStateClass">
	<a href="$AddToCartLink" class="button hide-for-product-in-cart">Add to Cart</a>
	<a href="$RemoveAllLink" class="button show-for-product-in-cart">Remove from Cart</a>
</div>
```


DEVELOPERS:
-----------
* Mark Guinn - mark@adaircreative.com

Pull requests always welcome. Follow Silverstripe coding standards.


LICENSE (MIT):
--------------
Copyright (c) 2014 Mark Guinn

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the
Software, and to permit persons to whom the Software is furnished to do so, subject
to the following conditions:

The above copyright notice and this permission notice shall be included in all copies
or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE
FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
DEALINGS IN THE SOFTWARE.
