# JWT token with public/private key

In my journey to find out how to generate and verify JWT tokens without the need to
have the secret key available on all token using systems, I came across the possibility
to use the RS256 signing algoritm which does exactly that.

The basic idea is that you need to have an RSA private key and the corresponding public
key. Obviously the private key only needs to be used in the system generating the JWT
tokens.

## Convenience Makefile
To conveniently test this, you'll need to have composer in your $PATH and run make.
Through make the following will be done:
1. Install the required PHP dependencies.
2. Generate a private RSA key with corresponding public key (output in the 'key' directory afterwards).
3. Run the unit test in the test dir.

Afterwards, the generated token will be output as well as the public and private key.
To actually verify that this works, check https://jwt.io.

## Rationale
You may wonder why you wouldn't just stick with an algorithm such as HS256 in combination
with a secret key.

If you have a bunch of systems using a generated token, all those systems need to have 
the private key used for signing the token, to verify that the token is actually
legit. This is a bad option, because when one of those system somehow exposes that
secret, an attacker is able to generate tokens with it.

When the public key gets exposed somehow, it's no big deal because it can't be used to
generate JWT tokens with it. 