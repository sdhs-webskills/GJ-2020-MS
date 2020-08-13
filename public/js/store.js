export default {
  state: {
    type: "basic",
    itemCount: 6,
    page: 0,
    cut: 0
  },
  commit (key, value) {
    this.state[key] = value;
  },
  commitByArrow (arrowType, key, last) {
    const now = this.state[key];
    const prev = () => {
      if (now > 0) this.state[key] -= 1;
    }
    const next = () => {
      if (now < last - 1) this.state[key] += 1;
    };
    ({ prev, next })[arrowType]();
  },
};