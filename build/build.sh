# 判断是否linux还是macos
# macos时变量名后缀为".dylib"
# linux时变量名后缀为".so"

if [ "$SYSTEM" = "Darwin" ]; then
suffix=".dylib"
else
suffix=".so"
fi

gcc parson.c -shared -o Json$suffix -O2 -Wall -Wextra -std=c89 -pedantic-errors -DTESTS_MAIN 