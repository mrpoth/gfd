<template>
  <form @submit.prevent="submit" >
    <label for="description">Review</label>
    <input type="hidden" name="game_id" :value="game.id">
    <input type="textarea" id="description" v-model="form.description" class="text-black"/>
    <button type="submit">Submit</button>
  </form>
</template>

<script>
export default {
    name: "Review",
    props: {
        game: Object,
        errors: Object
    },
  data() {
    return {
      form: {
        description: null,
        game_id: this.game.id,
        game_slug: this.game.slug
      },
    }
  },
  methods: {
    submit() {
      this.$inertia.post('/review', this.form)
    },
  },
}
</script>