import webbrowser

# Simpan HTML sebagai string
html_content = """<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Foundry - Wall Decoration eCommerce</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
  />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-white text-gray-900">
  <!-- Header -->
  <header class="border-b border-gray-300">
    <div class="container mx-auto flex items-center justify-between py-6 px-4 md:px-0 max-w-7xl">
      <a href="#" class="text-2xl font-semibold tracking-wide">Foundry</a>
      <nav class="hidden md:flex space-x-8 text-gray-700 font-medium">
        <a href="#" class="hover:text-gray-900 transition">Home</a>
        <a href="#" class="hover:text-gray-900 transition">Shop</a>
        <a href="#" class="hover:text-gray-900 transition">About</a>
        <a href="#" class="hover:text-gray-900 transition">Contact</a>
      </nav>
      <div class="md:hidden">
        <button aria-label="Open menu" class="text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900">
          <i class="fas fa-bars fa-lg"></i>
        </button>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="container mx-auto max-w-7xl px-4 md:px-0 py-20">
    <div class="text-center max-w-3xl mx-auto">
      <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight">
        Minimalist Wall Decorations for Modern Spaces
      </h1>
      <p class="text-gray-700 text-lg md:text-xl mb-10">
        Discover elegant, simple, and timeless wall art that transforms your home with style and sophistication.
      </p>
      <a href="#" class="inline-block bg-gray-900 text-white px-8 py-3 rounded-md font-semibold hover:bg-gray-700 transition">
        Shop Now
      </a>
    </div>
  </section>

  <!-- Product Grid -->
  <section class="container mx-auto max-w-7xl px-4 md:px-0 pb-20">
    <h2 class="text-3xl font-semibold mb-10 text-center">Featured Products</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
      <article class="border border-gray-300 rounded-md p-4 flex flex-col">
        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80"
          alt="Abstract Wall Art" class="w-full h-48 object-cover mb-4 rounded" />
        <h3 class="font-semibold text-lg mb-2">Abstract Wall Art</h3>
        <p class="text-gray-600 flex-grow">A modern abstract piece in black and white tones, perfect for any room.</p>
        <div class="mt-4 font-bold text-gray-900">$120</div>
      </article>

      <article class="border border-gray-300 rounded-md p-4 flex flex-col">
        <img src="https://images.unsplash.com/photo-1529101091764-c3526daf38fe?auto=format&fit=crop&w=400&q=80"
          alt="Geometric Wall Sculpture" class="w-full h-48 object-cover mb-4 rounded" />
        <h3 class="font-semibold text-lg mb-2">Geometric Wall Sculpture</h3>
        <p class="text-gray-600 flex-grow">Minimalist metal sculpture with clean lines and a matte black finish.</p>
        <div class="mt-4 font-bold text-gray-900">$180</div>
      </article>

      <article class="border border-gray-300 rounded-md p-4 flex flex-col">
        <img src="https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=400&q=80"
          alt="Monochrome Canvas Print" class="w-full h-48 object-cover mb-4 rounded" />
        <h3 class="font-semibold text-lg mb-2">Monochrome Canvas Print</h3>
        <p class="text-gray-600 flex-grow">Elegant black and white canvas print with subtle texture and depth.</p>
        <div class="mt-4 font-bold text-gray-900">$95</div>
      </article>

      <article class="border border-gray-300 rounded-md p-4 flex flex-col">
        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=400&q=80"
          alt="Minimalist Line Art" class="w-full h-48 object-cover mb-4 rounded" />
        <h3 class="font-semibold text-lg mb-2">Minimalist Line Art</h3>
        <p class="text-gray-600 flex-grow">Simple line drawing print in black ink on white background.</p>
        <div class="mt-4 font-bold text-gray-900">$75</div>
      </article>
    </div>
  </section>

  <!-- Footer -->
  <footer class="border-t border-gray-300 py-8">
    <div class="container mx-auto max-w-7xl px-4 md:px-0 text-center text-gray-600 text-sm">
      &copy; 2025 Foundry. All rights reserved.
    </div>
  </footer>
</body>
</html>"""

# Simpan ke file HTML
file_path = "foundry.html"
with open(file_path, "w", encoding="utf-8") as file:
    file.write(html_content)

# Buka di browser
webbrowser.open_new_tab(file_path)
