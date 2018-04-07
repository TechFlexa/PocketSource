/**
 * Copyright (c) 2017-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

/* List of projects/orgs using your project for the users page */
const users = [
  {
    caption: 'Vinay Khobragade',
    image: 'https://avatars2.githubusercontent.com/u/12556455?s=460&v=4',
    infoLink: 'https://techflexa.com',
    pinned: true,
  },
  {
    caption: 'Kuldeep Pisda',
    image: 'https://avatars1.githubusercontent.com/u/22424149?s=460&v=4',
    infoLink: 'https://kdpisda.tech',
    pinned: true,
  },
];

const siteConfig = {
  title: 'PocketSource' /* title for your website */,
  tagline: 'Open source project to manage resources',
  url: 'https://pocketsource.techflexa.com' /* your website url */,
  baseUrl: '/' /* base url for your project */,
  projectName: 'PocketSource',
  headerLinks: [
    {doc: 'getting-started', label: 'Docs'},
    {doc: 'doc4', label: 'API'},
    {page: 'help', label: 'Help'},
    {blog: true, label: 'Blog'},
  ],
  users,
  /* path to images for header/footer */
  headerIcon: 'img/techflexa.png',
  footerIcon: 'img/techflexa.png',
  favicon: 'img/favicon.png',
  /* colors for website */
  colors: {
    primaryColor: '#2E8555',
    secondaryColor: '#205C3B',
  },
  /* custom fonts for website */
  /*fonts: {
    myFont: [
      "Times New Roman",
      "Serif"
    ],
    myOtherFont: [
      "-apple-system",
      "system-ui"
    ]
  },*/
  // This copyright info is used in /core/Footer.js and blog rss/atom feeds.
  copyright:
    'Copyright © ' +
    new Date().getFullYear() +
    ' TechFlexa',
  organizationName: 'TechFlexa', // or set an env variable ORGANIZATION_NAME
  projectName: 'PocketSource', // or set an env variable PROJECT_NAME
  highlight: {
    // Highlight.js theme to use for syntax highlighting in code blocks
    theme: 'default',
  },
  scripts: ['https://buttons.github.io/buttons.js'],
  // You may provide arbitrary config keys to be used as needed by your template.
  repoUrl: 'https://github.com/techflexa/pocketsource',
  /* On page navigation for the current documentation page */
  // onPageNav: 'separate',
};

module.exports = siteConfig;
