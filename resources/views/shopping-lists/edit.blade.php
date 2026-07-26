<form action="{{ route(
'shopping-lists.update',
$item->id
) }}"
method="POST">

@csrf
@method('PUT')

<input
type="text"
name="item_name"
value="{{ $item->item_name }}"
>

<input
type="number"
name="quantity"
value="{{ $item->quantity }}"
>

<button>
Update
</button>

</form>