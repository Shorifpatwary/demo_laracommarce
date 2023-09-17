const postcssConfig = require("postcss-load-config");

module.exports = {
  // ...other configuration options...
  webpack: (config) => {
    // ...other webpack configuration...

    config.module.rules.push({
      test: /\.css$/,
      use: [
        "style-loader",
        "css-loader",
        {
          loader: "postcss-loader",
          options: {
            postcssOptions: async () => {
              const postcssConfig = await import("postcss-load-config");
              return postcssConfig({});
            },
          },
        },
      ],
    });

    return config;
  },
  devIndicators: {
    buildActivity: true, // You can keep this option
    buildActivityPosition: "bottom-left", // You can keep this option
  },
};
