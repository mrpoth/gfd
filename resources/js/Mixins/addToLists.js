const addToLists = {
  methods: {
    addToList(game, collectionOption) {
      axios
        .post("http://localhost:8000/game/store", {
          game: game,
          collectionOption: collectionOption,
        })
        .then((res) => {
          console.log(res.data);
          let message = res.data.message;
          this.showTooltip(game.id, message);
          if (res.data.error) {
            this.error = res.data.error;

            alert(this.error);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    showTooltip(id, message) {
      let tooltipId = id;
      let tooltipMessage = document.getElementById(tooltipId);
      if (message !== undefined) {
        tooltipMessage.innerHTML = message;
        tooltipMessage.classList.toggle("hidden-message");
        setTimeout(function () {
          tooltipMessage.style.display = "none";
        }, 1500);
      }
    },
  },
};

export default addToLists;
