import { NextResponse } from 'next/server';
import type { NextRequest } from 'next/server';
import { jwtVerify } from 'jose';

const JWT_SECRET = new TextEncoder().encode(
  process.env.JWT_SECRET || 'jurnal-pkl-secret-key-2026-very-secure-jwt-token'
);

export async function middleware(request: NextRequest) {
  const { pathname } = request.nextUrl;
  const token = request.cookies.get('token')?.value;

  let payload: any = null;
  if (token) {
    try {
      const verified = await jwtVerify(token, JWT_SECRET);
      payload = verified.payload;
    } catch (e) {
      payload = null;
    }
  }

  // Guest-only routes
  if (['/login', '/register'].includes(pathname)) {
    if (payload) {
      return NextResponse.redirect(new URL('/dashboard', request.url));
    }
    return NextResponse.next();
  }

  // Universal dashboard redirect
  if (pathname === '/dashboard') {
    if (!payload) {
      return NextResponse.redirect(new URL('/login', request.url));
    }

    switch (payload.role) {
      case 'siswa':
        return NextResponse.redirect(new URL('/siswa/dashboard', request.url));
      case 'guru_pembimbing':
        return NextResponse.redirect(new URL('/guru-pembimbing/dashboard', request.url));
      case 'mentor':
        return NextResponse.redirect(new URL('/mentor/dashboard', request.url));
      case 'admin_sekolah':
        return NextResponse.redirect(new URL('/admin-sekolah/dashboard', request.url));
      case 'kepala_sekolah':
        return NextResponse.redirect(new URL('/kepala-sekolah/dashboard', request.url));
      case 'admin_platform':
        return NextResponse.redirect(new URL('/admin-platform/dashboard', request.url));
      default:
        return NextResponse.redirect(new URL('/login', request.url));
    }
  }

  // Role-protected routes
  const protectedRoleRoutes = [
    { prefix: '/siswa', role: 'siswa' },
    { prefix: '/guru-pembimbing', role: 'guru_pembimbing' },
    { prefix: '/mentor', role: 'mentor' },
    { prefix: '/admin-sekolah', role: 'admin_sekolah' },
    { prefix: '/kepala-sekolah', role: 'kepala_sekolah' },
    { prefix: '/admin-platform', role: 'admin_platform' },
  ];

  for (const route of protectedRoleRoutes) {
    if (pathname.startsWith(route.prefix)) {
      if (!payload) {
        return NextResponse.redirect(new URL('/login', request.url));
      }
      if (payload.role !== route.role) {
        return NextResponse.redirect(new URL('/dashboard', request.url));
      }
    }
  }

  // Profile protection
  if (pathname.startsWith('/profile')) {
    if (!payload) {
      return NextResponse.redirect(new URL('/login', request.url));
    }
  }

  return NextResponse.next();
}

export const config = {
  matcher: [
    '/login',
    '/register',
    '/dashboard',
    '/profile/:path*',
    '/siswa/:path*',
    '/guru-pembimbing/:path*',
    '/mentor/:path*',
    '/admin-sekolah/:path*',
    '/kepala-sekolah/:path*',
    '/admin-platform/:path*',
  ],
};
