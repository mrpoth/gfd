<template>
  <div>
    <div class="flex-container">
      <form action="/results" method="POST">
        <input type="hidden" name="_token" v-bind:value="csrf" />
        <label for="search-game">Enter a game</label>
        <input name="search-game" id="search-game" />
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>
</template>
 <script>
export default {
  data() {
    return {
      //csrf token
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    };
  },
};
</script>
