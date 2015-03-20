<?php if (!empty($product->image_sm)): ?>
/uploads/{{ product.image_sm }}
<?php else: ?>
/img/media/{{product.name}}.jpg
<?php endif; ?>
