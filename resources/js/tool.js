Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'version-difference-viewer',
      path: '/version-difference-viewer',
      component: require('./components/Tool'),
    },
  ])
})
