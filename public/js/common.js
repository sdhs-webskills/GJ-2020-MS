import xml from './xml';
import { render } from "./renderer";
import { event } from "./events";

window.onload = async () => {
  await xml.load();
  event();
  render();
};