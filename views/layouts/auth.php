<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventaris TJKT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#2563EB',      // Biru lebih profesional
                        'brand-strong': '#1D4ED8',
                        'brand-medium': '#60A5FA',
                        'neutral-primary': '#FFFFFF',
                        'neutral-secondary-soft': '#F8FAFC',
                        heading: '#0F172A',     // Slate 900
                        body: '#475569',        // Slate 600
                        default: '#E2E8F0',     // Slate 200
                        'default-medium': '#CBD5E1'
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-neutral-secondary-soft to-white min-h-screen flex items-center justify-center p-4">
    <?php include $content; ?>
</body>
</html>