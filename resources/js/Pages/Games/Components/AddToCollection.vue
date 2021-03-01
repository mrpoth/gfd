<template>
  <div>
    <button class="add-to-collection">
      Add to
      <button @click="addToList(game, 'wishlist')" class="collection-options">
        Wishlist
      </button>
      <button @click="addToList(game)" class="collection-options">
        Library
      </button>
    </button>
    <select
      name="mobile-collection-options"
      @change="addToList(game, $event.target.value)"
      id="mobile-collection"
      class="mobile-collection-options"
    >
      <option value="" disabled selected hidden>Add to</option>
      <option value="wishlist">Wishlist</option>
      <option value="library">Library</option>
    </select>
    <p :id="game.id">{{ tooltipMessage }}</p>
  </div>
</template>

<script>
import addToLists from "../../../Mixins/addToLists";

export default {
  mixins: [addToLists],
  name: "AddToCollection",
  props: {
    game: Object
  },
  data() {
    return {
      error: "",
      tooltipMessage: "",
    };
  }
}
</script>