import $ from './jquery-3.5.0.min';

export default Object.freeze({
  data: null,

  async load () {
    const xmlData = await fetch("/xml/festivalList.xml").then(v => $.parseXML(v.text()));
    this.setData([ ...$(xmlData).find("item") ].map(({ children }) => {
      return [ children ].reduce((acc, { tagName, children, textContent }) => {
        acc[tagName] = tagName === "images" ?  [...children].map(v => v.textContent) :
                       tagName === "sn"     ?  `00${textContent}`.substr(-3) :
                       textContent;
        return acc;
      }, {});
    }));
  },

  setData (data) {
    this.data = data;
  },

  getData () {
    return this.data;
  },

})