import { HelloWorldNgPage } from './app.po';

describe('hello-world-ng App', () => {
  let page: HelloWorldNgPage;

  beforeEach(() => {
    page = new HelloWorldNgPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
