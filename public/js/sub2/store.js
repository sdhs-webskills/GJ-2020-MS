import service from "./service";

export default {

  state: {
    scrollData: JSON.parse(localStorage.getItem("scroll")) || 0,
    buttonData: JSON.parse(localStorage.getItem("button")) || false,
    items: [],
    set scroll (value) {
      this.scrollData = value;
      localStorage.setItem('scroll', value);
    },
    set button (value) {
      this.buttonData = value;
      localStorage.setItem('button', value);
    }
  },

  commit (key, value) {
    this.state[key] = value;
  },

  async loadItems () {
    const { statusCd, statusMsg, items } = await service.fetchCurrentExchangeRate();
    if( statusCd !== 200 ){
      throw statusMsg;
    }
    this.commit({ items });
  },

  getItemsSplice (size) {
    const { items } = this.state;
    return items.slice().splice(0, size);
  }

}